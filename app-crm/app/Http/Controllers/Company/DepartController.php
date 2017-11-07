<?php namespace Huifang\Crm\Http\Controllers\Company;


use Huifang\Crm\Http\Controllers\BaseController;
use Huifang\Crm\Src\Forms\Company\Depart\DepartSearchForm;
use Huifang\Crm\Src\Forms\Company\Depart\DepartStoreForm;
use Huifang\Service\Company\DepartService;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Illuminate\Http\Request;

class DepartController extends BaseController
{
    public function index(Request $request, $company_id, DepartSearchForm $form)
    {
        $this->title = '公司部门管理';
        $this->file_css = 'pages.company.depart.index';
        $this->file_js = 'pages.company.depart.index';
        $data = [];

        $request->merge(['company_id' => $company_id]);

        $form->validate($request->all());
        $depart_service = new DepartService($company_id);

        $data = $depart_service->getDepartList($form->depart_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->depart_specification);

        return $this->view('pages.company.depart.index', $data);
    }

    public function edit($company_id, $id)
    {
        $this->title = '公司部门管理';
        $this->file_css = 'pages.company.depart.edit';
        $this->file_js = 'pages.company.depart.edit';
        $data = [];
        if (!empty($id)) {
            $depart_service = new DepartService($company_id);
            $data = $depart_service->getDepartInfo($id);
        }
        $data['company_id'] = $company_id;
        $data['id'] = $id;


        return $this->view('pages.company.depart.edit', $data);
    }


    public function store(Request $request, DepartStoreForm $form)
    {
        $form->validate($request->all());
        $depart_repository = new DepartRepository();
        $depart_repository->save($form->depart_entity);
        return redirect()->to(route('company.depart.index', ['company_id' => $form->depart_entity->company_id]));
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
