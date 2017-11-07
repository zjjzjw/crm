<?php namespace Huifang\Web\Http\Controllers\Api;

use Huifang\Service\Customer\CustomerService;
use Huifang\Service\Role\UserService;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Customer\CustomerDeleteForm;
use Huifang\Web\Src\Forms\Customer\CustomerStoreForm;
use Huifang\Web\Src\Forms\Customer\CustomerSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Illuminate\Http\Request;


class CustomerController extends BaseController
{
    /**
     * @param Request            $request
     * @param CustomerSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerList(Request $request, CustomerSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);
        $user = $this->getUser();

        //全部客户列表
        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company_id, $user->id);
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        //加入自己
        $user_ids[] = $user->id;
        $request->merge(['company_id' => $user->company->id]);
        $request->merge(['user_ids' => $user_ids]);

        $form->validate($request->all());

        $customer_service = new CustomerService();
        $data = $customer_service->getTouchCustomerList($form->customer_specification, $per_page);

        return response()->json($data, 200);
    }

    /**
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerIndividualList(Request $request, CustomerSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);
        $user = $this->getUser();

        //我的客户列表
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company->id]);
        $form->validate($request->all());

        $customer_service = new CustomerService();
        $data = $customer_service->getTouchCustomerList($form->customer_specification, $per_page);

        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerListByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        $type = $request->get('type', '');
        $user = $this->getUser();

        $spec = new CustomerSpecification();
        $spec->keyword = $keyword;
        $spec->company_id = $user->company->id;
        //我的客户列表
        if ($type == 'sale.individual.list') {
            $spec->user_id = $user->id;
        } else {
            //全部客户列表
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
            $customer_service = new CustomerService();
            $data = $customer_service->getCustomerListByKeyword($spec);
        }
        return response()->json($data, 200);
    }

    /**
     * @param Request           $request
     * @param CustomerStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerStore(Request $request, CustomerStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $customer_repository = new CustomerRepository();
        $customer_repository->save($form->customer_entity);
        return response()->json($data, 200);
    }


    /**
     * 销售线索删除
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerDelete($id, Request $request, CustomerDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $customer_repository = new CustomerRepository();
        $customer_repository->delete($id);
        return response()->json($data, 200);
    }

}