<?php namespace Huifang\Web\Http\Controllers\User;

use Huifang\Service\Card\CardService;
use Huifang\Service\Contract\SignTaskService;
use Huifang\Service\Project\ProjectAimService;
use Huifang\Service\Project\ProjectService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Sale\SaleService;
use Huifang\Src\Contract\Infra\Repository\SignTaskRepository;
use Huifang\Src\Project\Domain\Model\AimHinderStatus;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderSpecification;
use Huifang\Src\Project\Infra\Repository\ProjectAimHinderRepository;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\Aim\AimHinderSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Huifang\Web\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 个人中心页面
     * @param Request $request
     * @return \View
     */
    public function userList(Request $request)
    {
        $data = [];
        $this->title = '个人中心';
        $this->file_css = 'user.list';
        return $this->view('touch.user.list', $data);
    }

    /**
     * 个人中心个人信息
     * @param Request $request
     * @return \View
     */
    public function userInfo(Request $request)
    {
        $data = [];
        $this->title = '个人信息';
        $this->file_css = 'user.info';
        $user = $this->getUser();
        $user_service = new UserService();
        $data = $user_service->getUserInfoById($user->id);

        return $this->view('touch.user.info', $data);
    }

    /**
     * 名片夹
     * @param Request $request
     * @return \View
     */
    public function userCardList(Request $request)
    {
        $data = [];
        $this->title = '名片夹';
        $this->file_css = 'user.card.list';
        $this->file_js = 'user.card.list';
        $user = $this->getUser();
        $card_service = new CardService();
        $alphas = $card_service->getCardList($user->id);
        $data['alphas'] = $alphas;
        return $this->view('touch.user.card.list', $data);
    }


    /**
     * 名片夹
     * @param Request $request
     * @return \View
     */
    public function userCardDetail(Request $request, $id)
    {
        $data = [];
        $this->title = '名片详情';
        $this->file_css = 'user.card.detail';
        $this->file_js = 'user.card.detail';
        $card_service = new CardService();
        $data = $card_service->getCardInfo($id);

        return $this->view('touch.user.card.detail', $data);
    }

    /**
     * 通信录
     * @param Request $request
     * @return \View
     */
    public function userContacts(Request $request)
    {
        $data = [];
        $this->title = '通讯录';
        $this->file_css = 'user.contacts';
        $this->file_js = 'user.contacts';
        $user = $this->getUser();
        $user_service = new UserService();
        $data = $user_service->getUserInfoById($user->id);
        $depart_users = $user_service->getCompanyDepartUsers($user->company->id);
        $data['depart_users'] = $depart_users;
        return $this->view('touch.user.contacts', $data);
    }

    /**
     * 通信录人人详情
     * @param Request $request
     * @param int     $id
     */
    public function userContactsDetail(Request $request, $id)
    {
        $data = [];
        $this->title = '通讯录';
        $this->file_css = 'user.contacts.detail';
        $this->file_js = 'user.contacts.detail';
        $user = $this->getUser();
        $user_service = new UserService();
        $data = $user_service->getUserInfoById($id);
        return $this->view('touch.user.contacts.detail', $data);
    }

    /** 我的审批
     * @return \View
     */
    public function userApprovalList()
    {
        $data = [];
        $this->title = '我的审批';
        $this->file_css = 'user.approval.list';
        return $this->view('touch.user.approval.list', $data);
    }

    /** 我的审批-销售线索
     * @return \View
     */
    public function userApprovalSaleList(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $this->title = '销售线索';
        $this->file_css = 'user.approval.sale.list';
        $this->file_js = 'user.approval.sale.list';
        $user = $this->getUser();
        //自己管理的数据
        $user_ids = [];

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);

        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);
        $form->validate($request->all());
        $sale_service = new SaleService();

        $data = $sale_service->getApprovalSaleList($form->sale_specification, 10);
        $data['search_users'] = $search_users;
        $sale_statuses = SaleStatus::acceptableAuditEnums();
        $data['sale_statuses'] = $sale_statuses;

        $appends = $this->getSalePageAppends($form->sale_specification);
        $appends['per_page'] = 10;
        $appends['page'] = $data['page']['current_page'] ?? 1;
        $data['appends'] = $appends;

        return $this->view('touch.user.approval.sale.list', $data);
    }

    /**
     * 消索线索详情页
     * @return \View
     */
    public function userApprovalSaleDetail($id)
    {
        $data = [];
        $this->title = '销售线索审核';
        $this->file_css = 'user.approval.sale.detail';
        $this->file_js = 'user.approval.sale.detail';
        $user = $this->getUser();
        $sale_service = new SaleService();
        $data = $sale_service->getSaleInfo($id);

        $sale_statuses = SaleStatus::acceptableEnums();
        $data['sale_statuses'] = $sale_statuses;

        return $this->view('touch.user.approval.sale.detail', $data);
    }


    /**
     * 障碍输出
     * @param Request $request
     * @return \View
     */
    public function userApprovalHinderList(Request $request, AimHinderSearchForm $form)
    {
        $data = [];
        $this->title = '障碍输出';
        $this->file_css = 'user.approval.hinder.list';
        $this->file_js = 'user.approval.hinder.list';
        $project_aim_service = new ProjectAimService();
        $user = $this->getUser();

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);

        //自己管理的数据
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);

        $form->validate($request->all());

        $data = $project_aim_service->getApprovalAimHinders($form);

        $data['search_users'] = $search_users;
        $appends = $this->getHinderPageAppends($form->aim_hinder_specification);

        //ajax 分页需要
        $appends['per_page'] = 10;
        $appends['page'] = $data['page']['current_page'] ?? 1;
        $data['appends'] = $appends;

        $aim_hinder_statuses = AimHinderStatus::acceptableEnums();
        $data['aim_hinder_statuses'] = $aim_hinder_statuses;

        return $this->view('touch.user.approval.hinder.list', $data);
    }


    /**
     * 障碍输出详情
     * @param Request $request
     * @return \View
     */
    public function userApprovalHinderDetail(Request $request, $id)
    {
        $data = [];
        $this->title = '障碍输出详情';
        $this->file_css = 'user.approval.detail';
        $this->file_js = 'user.approval.detail';
        $project_aim_service = new ProjectAimService();
        $data = $project_aim_service->getProjectAimHinderInfo($id);

        $aim_hinder_statuses = AimHinderStatus::acceptableEnums();
        $data['aim_hinder_statuses'] = $aim_hinder_statuses;

        return $this->view('touch.user.approval.hinder.detail', $data);
    }


    /**
     *
     * @param Request $request
     * @return \View
     */
    public function userApprovalDetailAim(Request $request, $aim_id)
    {
        $data = [];
        $this->title = '障碍目标详情';
        $this->file_css = 'user.approval.detailAim';

        $project_aim_service = new ProjectAimService();
        $data = $project_aim_service->getProjectAimInfo($aim_id);


        return $this->view('touch.user.approval.hinder.detail-aim', $data);
    }

    /**
     * 任务分配
     * @return \View
     */
    public function userSignTaskDistribution()
    {
        $data = [];
        $this->title = '任务分配';
        $this->file_css = 'user.sign-task.distribution';
        $this->file_js = 'user.sign-task.distribution';
        $user = $this->getUser();

        $user_service = new UserService();
        $depart_users = $user_service->getAssignUsers($user->company->id, $user->id);
        $data['depart_users'] = $depart_users;

        return $this->view('touch.user.sign-task.distribution', $data);
    }

    /**
     * 任务列表
     * @return \Views
     */
    public function userSignTaskList($user_id)
    {
        $data = [];
        $this->title = '任务列表';
        $this->file_css = 'user.sign-task.list';
        $choose = [
            'title' => $this->title,
            'url'   => route('user.sign-task.edit', ['id' => 0, 'user_id' => $user_id]), //添加签约任务
        ];
        $data['choose'] = $choose;

        $sign_task_service = new SignTaskService();
        $sign_tasks = $sign_task_service->getSignTasksByUserId($user_id);
        $data['sign_tasks'] = $sign_tasks;

        $data['user_id'] = $user_id;

        return $this->view('touch.user.sign-task.list', $data);
    }

    /**
     * 任务详情
     * @return \View
     */
    public function userSignTaskDetail($id)
    {
        $data = [];
        $this->title = '任务详情';
        $this->file_css = 'user.sign-task.detail';
        $sign_task_service = new SignTaskService();
        $data = $sign_task_service->getSignTaskInfo($id);
        return $this->view('touch.user.sign-task.detail', $data);
    }

    /**
     * 创建任务
     * @return \View
     */
    public function userSignTaskEdit(Request $request, $id)
    {
        $data = [];
        $this->title = '创建任务';
        $this->file_css = 'user.sign-task.edit';
        $this->file_js = 'user.sign-task.edit';
        $user_id = $request->get('user_id');
        $sign_task_service = new SignTaskService();
        if (!empty($id)) {
            $sign_task_service = new SignTaskService();
            $data = $sign_task_service->getSignTaskInfo($id);
        }
        $data['months'] = $sign_task_service->getMonthList();
        $data['user_id'] = $user_id;
        return $this->view('touch.user.sign-task.edit', $data);
    }

    /**
     * 意见反馈页面
     * @param Request $request
     * @return \View
     */
    public function userOpinion(Request $request)
    {
        $data = [];
        $this->title = '意见反馈';
        $this->file_css = 'user.opinion';
        $this->file_js = 'user.opinion';
        $user = $this->getUser();
        $user_service = new UserService();
        $data = $user_service->getUserInfoById($user->id);
        return $this->view('touch.user.opinion', $data);
    }

    /**
     * 设置页面
     * @param Request $request
     * @return \View
     */
    public function userSet(Request $request)
    {
        $data = [];
        $this->title = '设置';
        $this->file_css = 'user.set';
        $this->file_js = 'user.set';
        return $this->view('touch.user.set', $data);
    }

    /**
     * @param ProjectAimHinderSpecification $spec
     * @return array
     */
    protected function getHinderPageAppends(ProjectAimHinderSpecification $spec)
    {
        $appends = [];
        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        if ($spec->column) {
            $appends['column'] = $spec->column;
        } else {
            $appends['column'] = 'created_at';
        }

        if ($spec->sort) {
            $appends['sort'] = $spec->sort;
        } else {
            $appends['sort'] = 'desc';
        }

        return $appends;
    }

    /**
     * @param SaleSpecification $spec
     * @return array
     */
    protected function getSalePageAppends(SaleSpecification $spec)
    {
        $appends = [];
        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        if ($spec->column) {
            $appends['column'] = $spec->column;
        } else {
            $appends['column'] = 'created_at';
        }
        if ($spec->sort) {
            $appends['sort'] = $spec->sort;
        } else {
            $appends['sort'] = 'desc';
        }


        return $appends;
    }

}