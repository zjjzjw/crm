<?php namespace Huifang\Web\Http\Controllers\Api;

use Huifang\Service\Role\UserService;
use Huifang\Service\Sale\SaleService;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Sale\SaleDeleteForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Illuminate\Http\Request;


class SaleController extends BaseController
{
    /**
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleList(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);
        $user = $this->getUser();
        $request->merge(['company_id' => $user->company->id]);

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);
        $user_ids = [];
        $user_ids[] = 0;
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);

        $form->validate($request->all());
        $sale_service = new SaleService();
        $data = $sale_service->getTouchSaleList($form->sale_specification, $per_page);

        return response()->json($data, 200);
    }

    /**
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleIndividualList(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);
        $user = $this->getUser();
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company->id]);
        $form->validate($request->all());
        $sale_service = new SaleService();
        $data = $sale_service->getTouchSaleList($form->sale_specification, $per_page);

        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSaleListByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        $type = $request->get('type', '');
        $user = $this->getUser();
        $spec = new SaleSpecification();
        $spec->keyword = $keyword;
        $spec->company_id = $user->company->id;

        if ($type == 'sale.individual.list') {
            $spec->user_id = $user->id;
        }
        if (!empty($keyword)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleListByKeyword($spec, 10);
        }
        return response()->json($data, 200);
    }

    /**
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleStore(Request $request, SaleStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_repository = new SaleRepository();
        $sale_repository->save($form->sale_entity);
        return response()->json($data, 200);
    }

    /**
     * 销售线索分配
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleAssignUser(Request $request)
    {
        $data = [];
        $sale_id = $request->get('sale_id');
        $user_id = $request->get('user_id');
        if ($sale_id && $user_id) {
            $sale_repository = new SaleRepository();
            /** @var SaleEntity $sale_entity */
            $sale_entity = $sale_repository->fetch($sale_id);
            if (isset($sale_entity)) {
                $sale_entity->user_id = $user_id;
                $sale_entity->status = SaleStatus::ASSIGNED;
                $sale_repository->save($sale_entity);
            }
        }
        return response()->json($data, 200);
    }


    /**
     * 销售线索认领
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleClaim(Request $request)
    {
        $data = [];
        $sale_id = $request->get('sale_id');
        $user = $this->getUser();
        $user_id = $user->id;
        if ($sale_id && $user_id) {
            $sale_repository = new SaleRepository();
            /** @var SaleEntity $sale_entity */
            $sale_entity = $sale_repository->fetch($sale_id);
            if (isset($sale_entity)) {
                $sale_entity->user_id = $user_id;
                //装填变为待审核状态
                $sale_entity->status = SaleStatus::ASSIGNING;
                $sale_repository->save($sale_entity);
            }
        }
        return response()->json($data, 200);
    }

    /**
     * 销售线索删除
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleDelete($id, Request $request, SaleDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $sale_repository = new SaleRepository();
        $sale_repository->delete($id);
        return response()->json($data, 200);
    }

    /**
     * 销售线索审核
     * @param Request $request
     */
    public function saleAudit(Request $request)
    {
        $data = [];
        $id = $request->get('id');
        $status = $request->get('status');
        $sale_repository = new SaleRepository();
        /** @var SaleEntity $sale_entity */
        $sale_entity = $sale_repository->fetch($id);
        if (isset($sale_entity)) {
            if ($status == SaleStatus::TO_ASSIGN) {
                $sale_entity->status = SaleStatus::TO_ASSIGN;
                $sale_entity->user_id = 0;
            } else if ($status == SaleStatus::ASSIGNED) {
                $sale_entity->status = SaleStatus::ASSIGNED;
            }
            $sale_repository->save($sale_entity);
        }
        return response()->json($data, 200);
    }
}