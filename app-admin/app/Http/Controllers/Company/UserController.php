<?php namespace Huifang\Admin\Http\Controllers\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\Role\RoleStoreForm;
use Huifang\Admin\Src\Forms\Company\User\UserDataStoreForm;
use Huifang\Admin\Src\Forms\Company\User\UserDeleteForm;
use Huifang\Admin\Src\Forms\Company\User\UserPwdStoreForm;
use Huifang\Admin\Src\Forms\Company\User\UserSearchForm;
use Huifang\Admin\Src\Forms\Company\User\UserStoreForm;
use Huifang\Service\Company\DepartService;
use Huifang\Service\Role\UserDataService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Role\RoleService;
use Huifang\Src\Role\Domain\Model\UserSpecification;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(Request $request, UserSearchForm $form)
    {
        $this->title = '公司帐号管理';
        $this->file_css = 'pages.company.user.index';
        $this->file_js = 'pages.company.user.index';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $user_service = new UserService();
        $data = $user_service->getRoleList($form->user_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->user_specification);
        return $this->view('pages.company.user.index', $data);
    }

    public function edit($id)
    {
        $this->title = '帐号添加';
        $this->file_css = 'pages.company.user.edit';
        $this->file_js = 'pages.company.user.edit';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;

        $role_service = new RoleService();
        $depart_service = new DepartService($company_id);
        if (!empty($id)) {
            $user_service = new UserService();
            $data['user_info'] = $user_service->getUserInfoById($id);
        } else {
            $data['user_info'] = [];
        }

        $data['roles'] = $role_service->getRoleByCompanyId($company_id);
        $data['departs'] = $depart_service->getDepartByCompanyIdAndParentId($company_id, 0);
        $data['company_id'] = $company_id;
        $data['id'] = $id;
        return $this->view('pages.company.user.edit', $data);
    }

    /**
     * 人员的数据权限
     * @param int $id
     */
    public function data($id)
    {
        $this->title = '帐号数据权限';
        $this->file_css = 'pages.company.user.data';
        $this->file_js = 'pages.company.user.data';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $user_service = new UserService();
        $data['user_info'] = $user_service->getUserInfoById($id);
        $depart_service = new DepartService($company_id);
        $data['departs'] = $depart_service->getDepartByCompanyIdAndParentId($company_id, 0);
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

        return redirect()->to(route('company.user.index'));
    }


    public function dataStore(Request $request, UserDataStoreForm $form)
    {
        $form->validate($request->all());
        $user_data_service = new UserDataService();
        $user_data_service->storeDataDepartIds($form);

        return redirect()->to(route('company.user.index'));

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
     * @param $id
     * @return \View
     */
    public function pwd($id)
    {
        $this->title = '个人帐号密码修改';
        $this->file_css = 'pages.company.user.pwd';
        $this->file_js = 'pages.company.user.pwd';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $role_service = new RoleService();
        $depart_service = new DepartService($company_id);
        if (!empty($id)) {
            $user_service = new UserService();
            $data['user_info'] = $user_service->getUserInfoById($id);
        } else {
            $data['user_info'] = [];
        }

        $data['company_id'] = $company_id;
        $data['id'] = $id;

        return $this->view('pages.company.user.pwd', $data);
    }

    /**
     * 修改用户密码
     * @param Request          $request
     * @param UserPwdStoreForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pwdStore(Request $request, UserPwdStoreForm $form)
    {
        $form->validate($request->all());
        $user_data_service = new UserDataService();
        $user_data_service->storeUserPwd($form);
        return redirect()->to(route('company.user.index'));
    }


    /**
     * @param int            $id
     * @param Request        $request
     * @param UserDeleteForm $form
     */
    public function delete($id, Request $request, UserDeleteForm $form)
    {
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $user_repository = new UserRepository();
        $user_repository->delete($id);
        //返回到用户列表页
        return redirect()->to(route('company.user.index'));
    }
    public function getUserByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $user_repository = new UserRepository();
            $user_entities = $user_repository->getUserByKeyword($keyword);
            /** @var UserEntity $user_entities */
            foreach ($user_entities as $user_entitie) {
                $item = [];
                $item['id'] = $user_entitie->id;
                $item['name'] = $user_entitie->name;
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }


}
