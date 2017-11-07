<?php namespace Huifang\Admin\Http\Controllers\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\CompanyStoreForm;
use Huifang\Service\Company\CompanyService;
use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Company\Domain\Model\FreeType;
use Huifang\Src\Company\Infra\Repository\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{

    public function detail(Request $request)
    {
        $user = $this->getUser();
        $company_id = $user->company->id;
        $this->title = '公司信息';
        $this->file_css = 'pages.company.detail';
        $this->file_js = 'pages.company.detail';
        $data = [];
        $company_service = new CompanyService();
        $data = $company_service->getCompanyInfo($company_id);
        $free_types = FreeType::acceptableEnums();
        $data['free_types'] = $free_types;

        return $this->view('pages.company.detail', $data);
    }


}
