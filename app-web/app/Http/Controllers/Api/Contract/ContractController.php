<?php namespace Huifang\Web\Http\Controllers\Api\Contract;

use Huifang\Service\Contract\ContractService;
use Huifang\Service\Project\ProjectService;
use Huifang\Service\Role\UserService;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Contract\ContractDeleteForm;
use Huifang\Web\Src\Forms\Contract\ContractSearchForm;
use Huifang\Web\Src\Forms\Contract\ContractStoreForm;
use Huifang\Web\Src\Forms\Project\ProjectSearchForm;
use Huifang\Web\Src\Forms\Project\ProjectStoreForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Illuminate\Http\Request;


class ContractController extends BaseController
{
    /**
     * 全部项目列表API
     * @param Request            $request
     * @param ContractSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function contractList(Request $request, ContractSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);

        $user = $this->getUser();
        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company_id, $user->id);
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        //加入自己
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);
        $request->merge(['company_id' => $user->company_id]);

        $form->validate($request->all());
        $project_service = new ContractService();
        $data = $project_service->getTouchContractList($form->contract_specification, $per_page);

        return response()->json($data, 200);
    }

    /**
     * 我的项目列表API
     * @param Request            $request
     * @param ContractSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function contractIndividualList(Request $request, ContractSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);

        $user = $this->getUser();
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company_id]);

        $form->validate($request->all());
        $contract_service = new ContractService();
        $data = $contract_service->getTouchContractList($form->contract_specification, $per_page);

        return response()->json($data, 200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContractListByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        $type = $request->get('type', '');
        $spec = new ContractSpecification();
        $spec->keyword = $keyword;
        $user = $this->getUser();
        $spec->company_id = $user->company->id;
        //自己
        if ($type == 'contract.individual.list') {
            $spec->user_id = $user->id;
            //合伙
        } else {
            $user_service = new UserService();
            $search_users = $user_service->getSearchUsers($user->company_id, $user->id);
            $user_ids = [];
            foreach ($search_users as $search_user) {
                $user_ids[] = $search_user['id'];
            }
            //加入自己
            $user_ids[] = $user->id;
            $spec->user_ids = $user_ids;
        }
        if (!empty($keyword)) {
            $contract_service = new ContractService();
            $data = $contract_service->getContractListByKeyword($spec, 10);
        }
        return response()->json($data, 200);
    }

    /**
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function contractStore(Request $request, ContractStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $contract_repository = new ContractRepository();
        $contract_repository->save($form->contract_entity);
        return response()->json($data, 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function contractDelete($id, Request $request, ContractDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $contract_repository = new ContractRepository();
        $contract_repository->delete($id);
        return response()->json($data, 200);
    }

}