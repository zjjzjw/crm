<?php namespace Huifang\Crm\Http\Controllers\Company;


use Huifang\Crm\Http\Controllers\BaseController;
use Huifang\Crm\Src\Forms\Company\Role\RoleStoreForm;
use Huifang\Crm\Src\Forms\Company\User\UserDataStoreForm;
use Huifang\Crm\Src\Forms\Company\User\UserSearchForm;
use Huifang\Crm\Src\Forms\Company\User\UserStoreForm;
use Huifang\Service\Company\DepartService;
use Huifang\Service\Role\UserDataService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Role\RoleService;
use Huifang\Crm\Src\Forms\Company\User\UserPwdStoreForm;
use Huifang\Src\Role\Domain\Model\UserSpecification;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(Request $request, $company_id, UserSearchForm $form)
    {
        $this->title = '公司帐号管理';
        $this->file_css = 'pages.company.user.index';
        $this->file_js = 'pages.company.user.index';
        $data = [];
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $user_service = new UserService();
        $data = $user_service->getRoleList($form->user_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->user_specification);
        return $this->view('pages.company.user.index', $data);
    }


    public function edit($company_id, $id)
    {
        $this->title = '公司帐号添加';
        $this->file_css = 'pages.company.user.edit';
        $this->file_js = 'pages.company.user.edit';
        $data = [];
        $role_service = new RoleService();
        $depart_service = new DepartService($company_id);
        if (!empty($id)) {
            $user_service = new UserService();
            $data['user_info'] = $user_service->getUserInfoById($id);
        } else {
            $data['user_info'] = [];
        }
        $data['created_user_id'] = 1;//分配到那个用户下（先固定）
        $data['roles'] = $role_service->getRoleByCompanyId($company_id);
        $data['departs'] = $depart_service->getDepartByCompanyId($company_id);
        $data['company_id'] = $company_id;
        $data['id'] = $id;


        return $this->view('pages.company.user.edit', $data);
    }

    /**
     * 人员的数据权限
     * @param int $company_id
     * @param int $id
     */
    public function data($company_id, $id)
    {
        $this->title = '公司帐号数据权限';
        $this->file_css = 'pages.company.user.data';
        $this->file_js = 'pages.company.user.data';
        $data = [];
        $user_service = new UserService();
        $data['user'] = $user_service->getUserInfoById($id);
        $depart_service = new DepartService($company_id);
        $data['departs'] = $depart_service->getDepartByCompanyId($company_id);
        $user_data_service = new UserDataService();
        $user_data_ids = $user_data_service->getUserDataDepartIds($id);
        $data['user_data_ids'] = $user_data_ids;
        $data['company_id'] = $company_id;
        $data['id'] = $id;

        return $this->view('pages.company.user.data', $data);
    }


    public function store(Request $request, UserStoreForm $form)
    {
        $form->validate($request->all());
        $user_repository = new UserRepository();
        $user_repository->save($form->user_entity);

        return redirect()->to(route('company.user.index',
            ['company_id' => $form->user_entity->company_id]));
    }


    public function dataStore(Request $request, UserDataStoreForm $form)
    {
        $form->validate($request->all());
        $user_data_service = new UserDataService();
        $user_data_service->storeDataDepartIds($form);

        return redirect()->to(route('company.user.index',
            ['company_id' => $form->company_id]));

    }


    public function getPageAppends(UserSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

    /** 修改密码
     * @param $company_id
     * @param $id
     * @return \View
     */
    public function pwd($company_id, $id)
    {
        $this->title = '公司帐号密码修改';
        $this->file_css = 'pages.company.user.pwd';
        $this->file_js = 'pages.company.user.pwd ';
        $data = [];
        $role_service = new RoleService();
        $depart_service = new DepartService($company_id);
        if (!empty($id)) {
            $user_service = new UserService();
            $data['user'] = $user_service->getUserInfoById($id);
        } else {
            $data['user'] = [];
        }

        $data['company_id'] = $company_id;
        $data['id'] = $id;

        return $this->view('pages.company.user.pwd', $data);
    }


    /**
     * 修改用户密码
     * @param Request $request
     * @param         $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pwdStore(Request $request, UserPwdStoreForm $form)
    {
        $form->validate($request->all());
        $user_data_service = new UserDataService();
        $user_data_service->storeUserPwd($form);
        return redirect()->to(route('company.user.index', ['company_id' => $form->company_id]));
    }

}
