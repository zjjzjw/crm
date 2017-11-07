<?php namespace Huifang\Crm\Http\Controllers\Company;


use Huifang\Crm\Http\Controllers\BaseController;
use Huifang\Crm\Src\Forms\Company\CompanySearchForm;
use Huifang\Crm\Src\Forms\Company\CompanyStoreForm;
use Huifang\Service\Company\CompanyService;
use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Company\Domain\Model\FreeType;
use Huifang\Src\Company\Infra\Repository\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, CompanySearchForm $form)
    {
        $data = [];
        $this->title = '公司管理';
        $this->file_css = 'pages.company.index';
        $this->file_js = 'pages.company.index';
        $form->validate($request->all());
        $company_service = new CompanyService();
        $data = $company_service->getCompanyList($form->company_specification, 20);

        $appends = $this->getPageAppends($form->company_specification);
        $data['appends'] = $appends;

        return $this->view('pages.company.index', $data);
    }

    public function edit(Request $request, $id)
    {

        $this->title = '公司编辑';
        $this->file_css = 'pages.company.edit';
        $this->file_js = 'pages.company.edit';
        $data = [];
        if (!empty($id)) {
            $company_service = new CompanyService();
            $data = $company_service->getCompanyInfo($id);
        }
        $free_types = FreeType::acceptableEnums();
        $data['free_types'] = $free_types;

        return $this->view('pages.company.edit', $data);
    }


    public function store(Request $request, CompanyStoreForm $form)
    {
        $form->validate($request->all());
        $company_repository = new CompanyRepository();
        $company_repository->save($form->company_entity);
        return redirect()->to(route('company.index'));
    }

    /**
     * @param CompanySpecification $spec
     * @return  array
     */
    public function getPageAppends(CompanySpecification $spec)
    {
        $appends = [];
        if ($spec->start_time) {
            $appends['start_time'] = $spec->start_time->toDateString();
        }
        if ($spec->end_time) {
            $appends['end_time'] = $spec->end_time->toDateString();
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;

    }

}
