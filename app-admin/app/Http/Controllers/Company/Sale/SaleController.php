<?php namespace Huifang\Admin\Http\Controllers\Company\Sale;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Sale\SaleImportStoreForm;
use Huifang\Admin\Src\Forms\Sale\SaleStoreForm;
use Huifang\Service\Sale\SaleService;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Illuminate\Http\Request;

class SaleController extends BaseController
{
    public function index(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $this->title = '销售线索列表';
        $this->file_css = 'pages.company.sale.sale.index';
        $this->file_js = 'pages.company.sale.sale.index';
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $per_page = $request->get('per_page', 20);
        $sale_service = new SaleService();
        $data = $sale_service->getSaleList($form->sale_specification, $per_page);

        $appends = $this->getPageAppends($form->sale_specification);
        $data['appends'] = $appends;
        return $this->view('pages.company.sale.sale.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $this->title = '销售线索编辑';
        $this->file_css = 'pages.company.sale.sale.edit';
        $this->file_js = 'pages.company.sale.sale.edit';
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleInfo($id);
        }
        $data['project_step_types'] = ProjectStepType::acceptableEnums();
        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForSearch();
        return $this->view('pages.company.sale.sale.edit', $data);
    }

    /**
     * @param Request $request
     * @param         $id
     */
    public function delete(Request $request, $id)
    {
        $sale_repository = new SaleRepository();
        $sale_repository->delete($id);
        return redirect()->to(route('company.sale.sale.index'));
    }


    public function import()
    {
        $data = [];
        $this->title = '销售线索数据导入';
        $this->file_css = 'pages.company.sale.import';
        $this->file_js = 'pages.company.sale.import';

        return $this->view('pages.company.sale.sale.import', $data);
    }


    public function importStore(Request $request, SaleImportStoreForm $form)
    {
        $user = $this->getUser();
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->importSaleData($user, $form->rows);

        return redirect()->to(route('company.sale.sale.index'));

    }

    public function saleStore(Request $request, SaleStoreForm $form)
    {
        $form->validate($request->all());
        $sale_repository = new SaleRepository();
        $sale_repository->save($form->sale_entity);
        return redirect()->to(route('company.sale.sale.index'));
    }

    /**
     * @param SaleSpecification $spec
     * @return array
     */
    protected function getPageAppends(SaleSpecification $spec)
    {
        $appends = [];
        if ($spec->project_volume_type) {
            $appends['project_volume_type'] = $spec->project_volume_type;
        }
        if ($spec->city_id) {
            $appends['city_id'] = $spec->city_id;
        }
        if ($spec->province_id) {
            $appends['province_id'] = $spec->province_id;
        }
        if ($spec->project_step_type) {
            $appends['project_step_type'] = $spec->project_step_type;
        }
        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }
        if ($spec->close_status) {
            $appends['close_status'] = $spec->close_status;
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}