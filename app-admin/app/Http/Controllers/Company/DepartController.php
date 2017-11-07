<?php namespace Huifang\Admin\Http\Controllers\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\Depart\DepartDeleteForm;
use Huifang\Admin\Src\Forms\Company\Depart\DepartSearchForm;
use Huifang\Admin\Src\Forms\Company\Depart\DepartStoreForm;
use Huifang\Service\Company\DepartService;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Illuminate\Http\Request;

class DepartController extends BaseController
{
    public function index(Request $request, DepartSearchForm $form)
    {
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $this->title = '部门管理';
        $this->file_css = 'pages.company.depart.index';
        $this->file_js = 'pages.company.depart.index';

        $request->merge(['company_id' => $company_id, 'parent_id' => 0]);

        $form->validate($request->all());
        $depart_service = new DepartService($company_id);

        $data = $depart_service->getDepartList($form->depart_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->depart_specification);
        return $this->view('pages.company.depart.index', $data);
    }

    public function edit($id)
    {
        $data = [];
        $this->title = '添加部门';
        $this->file_css = 'pages.company.depart.edit';
        $this->file_js = 'pages.company.depart.edit';
        $user = $this->getUser();
        $company_id = $user->company->id;

        if (!empty($id)) {
            $depart_service = new DepartService($company_id);
            $data = $depart_service->getDepartInfo($id);
        }
        $data['id'] = $id;
        return $this->view('pages.company.depart.edit', $data);
    }

    /**
     * 删除不能
     * @param int              $id
     * @param Request          $request
     * @param DepartDeleteForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, Request $request, DepartDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $depart_repository = new DepartRepository();
        $depart_repository->delete($id);
        return redirect()->to(route('company.depart.index'));
    }


    public function store(Request $request, DepartStoreForm $form)
    {
        $form->validate($request->all());
        $depart_repository = new DepartRepository();
        $depart_repository->save($form->depart_entity);
        return redirect()->to(route('company.depart.index'));
    }

    /**
     * @param DepartSpecification $spec
     */
    public function getPageAppends(DepartSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}
