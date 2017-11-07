<?php namespace Huifang\Crm\Http\Controllers\Company;


use Huifang\Crm\Http\Controllers\BaseController;
use Huifang\Crm\Src\Forms\Company\Role\RoleSearchForm;
use Huifang\Crm\Src\Forms\Company\Role\RoleStoreForm;
use Huifang\Src\Role\Domain\Model\RoleSpecification;
use Huifang\Service\Role\RoleService;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function index(Request $request, $company_id, RoleSearchForm $form)
    {

        $this->title = '公司角色管理';
        $this->file_css = 'pages.company.role.index';
        $this->file_js = 'pages.company.role.index';
        $data = [];

        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());

        $role_service = new RoleService();
        $data = $role_service->getRoleList($form->role_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->role_specification);

        return $this->view('pages.company.role.index', $data);
    }

    public function edit($company_id, $id)
    {
        $this->title = '公司角色管理';
        $this->file_css = 'pages.company.role.edit';
        $this->file_js = 'pages.company.role.edit';
        $data = [];
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

    public function store(Request $request, RoleStoreForm $form)
    {
        $form->validate($request->all());
        $role_repository = new RoleRepository();
        $role_repository->save($form->role_entity);
        return redirect()->to(route('company.role.index',
            ['company_id' => $form->role_entity->company_id]));
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
