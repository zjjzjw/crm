<?php namespace Huifang\Web\Http\Controllers\Contract;

use Carbon\Carbon;
use Huifang\Service\Contract\ContractService;
use Huifang\Service\Contract\SignTaskService;
use Huifang\Service\Customer\CustomerService;
use Huifang\Service\Product\ProductService;
use Huifang\Service\Project\ProjectService;
use Huifang\Service\Role\UserService;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Product\Domain\Model\AscriptionType;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Contract\ContractSearchForm;
use Illuminate\Http\Request;

class ContractController extends BaseController
{
    public function contractList(Request $request, ContractSearchForm $form)
    {
        $data = [];
        $this->title = '全部合同';
        $this->file_css = 'contract.list';
        $this->file_js = 'contract.list';
        $user = $this->getUser();
        //设置数据权限
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
        $data = $this->getDataList($request, $form);

        $data['search_users'] = $search_users;
        $data['route_name'] = 'contract.list';

        return $this->view('touch.contract.list', $data);
    }

    //我的合同
    public function contractIndividualList(Request $request, ContractSearchForm $form)
    {
        $data = [];
        $this->title = '我的合同';
        $this->file_css = 'contract.list';
        $this->file_js = 'contract.list';
        $user = $this->getUser();

        //设置数据权限
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company->id]);

        $data = $this->getDataList($request, $form);
        $data['route_name'] = 'contract.individual.list';
        return $this->view('touch.contract.list', $data);
    }


    public function getDataList(Request $request, ContractSearchForm $form)
    {
        $contract_service = new ContractService();
        $per_page = $request->get('per_page', 10);
        $form->validate($request->all());
        $data = $contract_service->getTouchContractList($form->contract_specification, $per_page);
        $appends = $this->getPageAppends($form->contract_specification);
        //ajax 分页需要
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;

        $choose = [
            'title'        => $this->title,
            'url'          => route('contract.edit', ['id' => 0]),
            'choose_items' => [
                [
                    'url'  => route('contract.list'),
                    'name' => '全部合同',
                ],
                [
                    'url'  => route('contract.individual.list'),
                    'name' => '我的合同',
                ],
            ],
        ];
        $data['choose'] = $choose;
        $data['appends'] = $appends;
        return $data;
    }


    //编辑
    public function contractEdit(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'contract.edit';
        $this->file_js = 'contract.edit';
        if ($id) {
            $this->title = '编辑合同';
        } else {
            $this->title = '创建合同';
        }
        $user = $this->getUser();

        $contract_service = new ContractService();
        $data = $contract_service->getContractInfo($id);

        $product_service = new ProductService();
        $select_products = $product_service->getProductsByCompanyId($user->company->id, AscriptionType::TYPE_OWNER);

        $data['select_products'] = $select_products;

        $customer_service = new CustomerService();
        $customers = $customer_service->getCustomersByUserId($user->id);
        $data['customers'] = $customers;


        return $this->view('touch.contract.edit', $data);
    }

    //详情页
    public function contractDetail(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'contract.detail';
        $this->file_js = 'contract.detail';
        $this->title = '合同详情';
        $contract_service = new ContractService();
        $data = $contract_service->getContractInfo($id);
        return $this->view('touch.contract.detail', $data);
    }

    /**
     * @param ContractSpecification $spec
     * @return array
     */
    protected function getPageAppends(ContractSpecification $spec)
    {
        $appends = [];
        if ($spec->user_id) {
            $appends['user_id'] = $spec->user_id;
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }
        return $appends;
    }


    /**
     * 合同回款进度员工列表
     * @return \View
     */
    public function contractPaymentSchedule()
    {
        $data = [];
        $this->title = '回款进度';
        $this->file_css = 'contract.payment-schedule';
        $this->file_js = 'contract.payment-schedule';
        $user = $this->getUser();
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;

        $user_service = new UserService();
        $depart_users = $user_service->getAssignUsers($user->company->id, $user->id);
        $data['depart_users'] = $depart_users;

        return $this->view('touch.contract.payment-schedule', $data);
    }

    /**
     * 员工回款进度月份列表
     * @param $user_id
     * @return \View
     */
    public function contractPaymentScheduleList($user_id)
    {
        $data = [];
        $this->title = '回款进度';
        $this->file_css = 'contract.payment-schedule-list';

        $contract_service = new ContractService();
        $months = $contract_service->getPaymentScheduleMonths();
        $data['months'] = $months;
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        $data['user_id'] = $user_id;

        return $this->view('touch.contract.payment-schedule-list', $data);
    }

    //回款详情
    public function contractPaymentScheduleDetail(Request $request, $user_id)
    {
        $data = [];
        $this->title = '回款详情';
        $this->file_css = 'contract.payment-schedule-detail';
        $month = $request->get('month');

        $contract_service = new ContractService();
        $start_time = Carbon::createFromFormat('Ym', $month)->startOfMonth();
        $end_time = Carbon::createFromFormat('Ym', $month)->endOfMonth();
        $user = \Huifang\Web\User::find($user_id);
        $contract_data = $contract_service->getContractPaymentScheduleByUser($user, $start_time, $end_time);
        $data['contract_data'] = $contract_data;
        $data['user_id'] = $user_id;

        return $this->view('touch.contract.payment-schedule-detail', $data);
    }


    //签单进度
    public function contractSignedProgress()
    {
        $data = [];
        $this->title = '签单进度';
        $this->file_css = 'contract.signed-progress';
        $this->file_js = 'contract.signed-progress';
        $user = $this->getUser();
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        $user_service = new UserService();
        $depart_users = $user_service->getAssignUsers($user->company->id, $user->id);
        $data['depart_users'] = $depart_users;
        return $this->view('touch.contract.signed-progress', $data);
    }


    //签单列表
    public function contractSignedProgressList($user_id)
    {
        $data = [];
        $this->title = '签单列表';
        $this->file_css = 'contract.signed-progress-list';

        $sign_task_service = new SignTaskService();
        $months = $sign_task_service->getTaskSignMonths($user_id);
        $data['months'] = $months;
        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        $data['user_id'] = $user_id;

        return $this->view('touch.contract.signed-progress-list', $data);
    }


    //签单详情
    public function contractSignedProgressDetail(Request $request, $user_id)
    {
        $data = [];
        $this->title = '签单详情';
        $this->file_css = 'contract.signed-progress-detail';
        $month = $request->get('month');
        $contract_service = new ContractService();
        $contract_data = $contract_service->getSignProgressByUserIdAndMonth($user_id, $month);
        $data['contract_data'] = $contract_data;

        return $this->view('touch.contract.signed-progress-detail', $data);
    }


}