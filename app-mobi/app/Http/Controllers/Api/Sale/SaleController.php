<?php namespace Huifang\Mobi\Http\Controllers\Api\Sale;

use Huifang\Mobi\Http\Controllers\BaseController;
use Huifang\Mobi\Src\Forms\Sale\SaleDeleteForm;
use Huifang\Mobi\Src\Forms\Sale\SaleSearchForm;
use Huifang\Mobi\Src\Forms\Sale\SaleStoreForm;
use Huifang\Mobi\Src\Service\Sale\SaleMobiService;
use Huifang\Mobi\Src\Service\Role\UserMobiService;
use Huifang\Service\Company\DepartService;
use Huifang\Service\Role\TokenService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Sale\SaleService;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Sale\Domain\Model\SaleCloseStatus;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Illuminate\Http\Request;
use SuperClosure\Analyzer\Token;


class SaleController extends BaseController
{
    public function filterParams()
    {
        $data = [];
        //体量搜索
        $project_volume_types = ProjectVolumeType::acceptableList();
        $data['project_volume_types'] = $project_volume_types;

        //阶段
        $project_step_types = ProjectStepType::acceptableList();
        $data['project_step_types'] = $project_step_types;

        //销售线索关闭原因
        $sale_close_statuses = SaleCloseStatus::acceptableList();
        $sale_close_status['id'] = '0';
        $sale_close_status['name'] = '不限';
        array_unshift($sale_close_statuses, $sale_close_status);
        $data['sale_close_statuses'] = $sale_close_statuses;

        //省市
        $province_service = new ProvinceService();
        $area = $province_service->getProvinceForMobi();
        $data['area'] = $area;

        //管理的人员
        $user_mobi_service = new UserMobiService();
        $user_entity = TokenService::getUserEntity();
        $search_users = $user_mobi_service->getSearchUsers($user_entity->company_id, $user_entity->id);
        $data['search_users'] = $search_users;

        return response()->json(format_data($data), 200);
    }

    /**
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleList(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);
        $user_entity = TokenService::getUserEntity();
        $request->merge(['company_id' => $user_entity->company_id]);
        $user_service = new UserService();

        $search_users = $user_service->getSearchUsers($user_entity->company_id, $user_entity->id);
        $user_ids = [];
        $user_ids[] = 0;
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user_entity->id;
        $request->merge(['user_ids' => $user_ids]);

        $form->validate($request->all());
        $sale_mobi_service = new SaleMobiService();
        $data = $sale_mobi_service->getMobiSaleList($form->sale_specification, $per_page);

        return response()->json(format_data($data), 200);
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
        $user_entity = TokenService::getUserEntity();
        $request->merge(['user_id' => $user_entity->id]);
        $request->merge(['company_id' => $user_entity->company_id]);
        $form->validate($request->all());
        $sale_mobi_service = new SaleMobiService();
        $data = $sale_mobi_service->getMobiSaleList($form->sale_specification, $per_page);

        return response()->json(format_data($data), 200);
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
        $user_entity = TokenService::getUserEntity();
        $spec = new SaleSpecification();
        $spec->keyword = $keyword;
        $spec->company_id = $user_entity->company_id;

        if ($type == 'sale.individual.list') {
            $spec->user_id = $user_entity->id;
        } else {
            $user_service = new UserService();
            $search_users = $user_service->getSearchUsers($user_entity->company_id, $user_entity->id);
            $user_ids = [];
            foreach ($search_users as $search_user) {
                $user_ids[] = $search_user['id'];
            }
            $user_ids[] = $user_entity->id;
            $spec->user_ids = $user_ids;
        }
        $sale_mobi_service = new SaleMobiService();
        $data = $sale_mobi_service->getMobiSaleListByKeyword($spec, false);
        return response()->json(format_data($data), 200);
    }

    /**
     * 创建销售线索
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
        $data['id'] = $form->sale_entity->id;
        $data['success'] = true;
        return response()->json(format_data($data), 200);
    }

    /**
     * 更新销售线索
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleUpdate(Request $request, SaleStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_repository = new SaleRepository();
        $sale_repository->save($form->sale_entity);
        $data['id'] = $form->sale_entity->id;
        $data['success'] = true;
        return response()->json(format_data($data), 200);
    }


    /**
     * 删除销售线索
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleDelete(Request $request, SaleDeleteForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_repository = new SaleRepository();
        $sale_repository->delete($form->id);
        $data['success'] = 'true';
        return response()->json(format_data($data), 200);
    }


    /**
     * 销售线索详情
     * @param         $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleDetail($id, Request $request)
    {
        $data = [];
        $sale_mobi_service = new SaleMobiService();
        $sale = $sale_mobi_service->getMobiSaleInfo($id);
        $data['sale'] = $sale;
        return response()->json(format_data($data), 200);
    }


    /**
     * 得到销售线索分配人员
     * @param Request $request
     */
    public function getSaleAssignUsers(Request $request)
    {
        $data = [];
        $sale_mobi_service = new SaleMobiService();
        $data = $sale_mobi_service->getSaleAssignUsers();
        return response()->json(format_data($data), 200);
    }


    /**
     * 分配销售线索
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
        $data['success'] = true;
        return response()->json(format_data($data), 200);
    }

}