<?php namespace Huifang\Mobi\Http\Controllers\Api;


use Huifang\Mobi\Http\Controllers\BaseController;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Sale\Domain\Model\SaleCloseStatus;

class ConfigController extends BaseController
{
    /**
     * 系统配置参数
     * @return \Illuminate\Http\JsonResponse
     */
    public function config()
    {
        $data = [];

        //阶段
        $project_step_types = ProjectStepType::acceptableList();
        //unset($project_step_types[0]);
        $data['project_step_types'] = array_values($project_step_types);

        //销售线索关闭原因
        $sale_close_statuses = SaleCloseStatus::acceptableList();
        $data['sale_close_statuses'] = array_values($sale_close_statuses);

        //省市
        $province_service = new ProvinceService();
        $area = $province_service->getProvinceForSale();
        $data['area'] = $area;

        return response()->json(format_data($data), 200);
    }
}
