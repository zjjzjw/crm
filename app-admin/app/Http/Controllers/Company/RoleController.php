<?php namespace Huifang\Admin\Http\Controllers\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\Role\RoleDeleteForm;
use Huifang\Admin\Src\Forms\Company\Role\RoleSearchForm;
use Huifang\Admin\Src\Forms\Company\Role\RoleStoreForm;
use Huifang\Src\Role\Domain\Model\RoleSpecification;
use Huifang\Service\Role\RoleService;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function index(Request $request, RoleSearchForm $form)
    {

        $this->title = '角色管理';
        $this->file_css = 'pages.company.role.index';
        $this->file_js = 'pages.company.role.index';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;

        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $role_service = new RoleService();
        $data = $role_service->getRoleList($form->role_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->role_specification);

        return $this->view('pages.company.role.index', $data);
    }

    public function edit($id)
    {
        $this->title = '角色添加';
        $this->file_css = 'pages.company.role.edit';
        $this->file_js = 'pages.company.role.edit';

        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;

        $role_service = new RoleService();
        if (!empty($id)) {
            $data = $role_service->getRoleInfo($id);
        } else {
            $data['permissions'] = [];
        }


        $data['all_permissions'] = $role_service->getPermissions();
        $data['company_id'] = $company_id;
        $data['id'] = $id;


        return $this->view('pages.company.role.edit', $data);
    }

    /**
     * 角色保存功能
     * @param Request       $request
     * @param RoleStoreForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, RoleStoreForm $form)
    {
        $form->validate($request->all());
        $role_repository = new RoleRepository();
        $role_repository->save($form->role_entity);
        return redirect()->to(route('company.role.index'));
    }

    /**
     * @param int           $id
     * @param Request       $request
     * @param RoleStoreForm $form
     */
    public function delete($id, Request $request, RoleDeleteForm $form)
    {
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $role_repository = new RoleRepository();
        $role_repository->delete($id);

        return redirect()->to(route('company.role.index'));
    }

    /**
     * @param RoleSpecification $spec
     */
    public function getPageAppends(RoleSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}
