<?php namespace Huifang\Admin\Http\Controllers\Company\Sale;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Service\Sale\LargeArea\LargeAreaService;
use Huifang\Service\Sale\SaleService;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Admin\Src\Forms\Sale\SaleSearchForm;
use Huifang\Src\Sale\Domain\Model\DecorationType;
use Huifang\Src\Sale\Domain\Model\ProjectEstimateStatus;
use Huifang\Src\Sale\Domain\Model\ProjectPositionType;
use Huifang\Src\Sale\Domain\Model\ProjectScheduleType;
use Huifang\Src\Sale\Domain\Model\ProjectStatus;
use Huifang\Src\Sale\Domain\Model\PropertyType;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SampleHouseType;
use Huifang\Src\Sale\Domain\Model\SellingStatus;
use Huifang\Src\Sale\Domain\Model\StrategyType;
use Illuminate\Http\Request;


class SalePropertyController extends BaseController
{
    public function index(Request $request, SaleSearchForm $form)
    {
        $this->title = '楼盘数据';
        $this->file_css = 'pages.company.sale.sale-property.index';
        $this->file_js = 'pages.company.sale.sale-property.index';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $per_page = $request->get('per_page', 20);
        $sale_service = new SaleService();
        $data = $sale_service->getSaleListAndProperty($form->sale_specification, $per_page);

        $appends = $this->getPageAppends($form->sale_specification);
        $data['appends'] = $appends;
        return $this->view('pages.company.sale.sale-property.index', $data);
    }

    public function essential(Request $request, $id)
    {
        $this->title = '楼盘数据-基本信息';
        $this->file_css = 'pages.company.sale.sale-property.essential';
        $this->file_js = 'pages.company.sale.sale-property.essential';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleAndPropertyInfo($id);
        }
        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForSearch();
        $data['selling_status'] = SellingStatus::acceptableEnums();
        $large_area_service = new LargeAreaService();
        $data['large_areas'] = $large_area_service->getLargeAreaByCompanyId($company_id);
        $data['id'] = $id;
        return $this->view('pages.company.sale.sale-property.essential', $data);
    }

    public function building(Request $request, $id)
    {
        $this->title = '楼盘数据-建筑信息';
        $this->file_css = 'pages.company.sale.sale-property.building';
        $this->file_js = 'pages.company.sale.sale-property.building';
        $data = [];
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleAndPropertyInfo($id);
        }
        $data['decoration_types'] = DecorationType::acceptableEnums();
        $data['project_schedules'] = ProjectScheduleType::acceptableEnums();
        $data['id'] = $id;
        return $this->view('pages.company.sale.sale-property.building', $data);
    }

    public function property(Request $request, $id)
    {
        $this->title = '楼盘数据-物业信息';
        $this->file_css = 'pages.company.sale.sale-property.property';
        $this->file_js = 'pages.company.sale.sale-property.property';
        $data = [];
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleAndPropertyInfo($id);
        }
        $data['property_types'] = PropertyType::acceptableEnums();
        $data['id'] = $id;
        return $this->view('pages.company.sale.sale-property.property', $data);
    }

    public function sales(Request $request, $id)
    {
        $this->title = '楼盘数据-销售信息';
        $this->file_css = 'pages.company.sale.sale-property.sales';
        $this->file_js = 'pages.company.sale.sale-property.sales';
        $data = [];
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleAndPropertyInfo($id);
        }
        $data['has_sample_houses'] = SampleHouseType::acceptableEnums();
        $data['id'] = $id;
        return $this->view('pages.company.sale.sale-property.sales', $data);
    }

    public function follow(Request $request, $id)
    {
        $this->title = '楼盘数据-跟进信息';
        $this->file_css = 'pages.company.sale.sale-property.follow';
        $this->file_js = 'pages.company.sale.sale-property.follow';
        $data = [];
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleAndPropertyInfo($id);
        }
        $data['strategy_ids'] = StrategyType::acceptableEnums();
        $data['project_positions'] = ProjectPositionType::acceptableEnums();
        $data['project_status_type'] = ProjectStatus::acceptableEnums();
        $data['project_estimate_status_type'] = ProjectEstimateStatus::acceptableEnums();
        $data['id'] = $id;
        return $this->view('pages.company.sale.sale-property.follow', $data);
    }

    public function other(Request $request, $id)
    {
        $this->title = '楼盘数据-其他信息';
        $this->file_css = 'pages.company.sale.sale-property.other';
        $this->file_js = 'pages.company.sale.sale-property.other';
        $data = [];
        if (!empty($id)) {
            $sale_service = new SaleService();
            $data = $sale_service->getSaleAndPropertyInfo($id);
        }
        $data['id'] = $id;
        return $this->view('pages.company.sale.sale-property.other', $data);
    }

    public function import()
    {
        $this->title = '楼盘数据信息导入';
        $this->file_css = 'pages.company.sale.sale-property.import';
        $this->file_js = 'pages.company.sale.sale-property.import';
        $data = [];

        return $this->view('pages.company.sale.sale-property.import', $data);
    }

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