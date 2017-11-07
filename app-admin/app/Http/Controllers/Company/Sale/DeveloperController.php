<?php namespace Huifang\Admin\Http\Controllers\Company\Sale;

use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Service\Sale\Developer\DeveloperService;
use Huifang\Admin\Src\Forms\Sale\Developer\DeveloperSearchForm;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;
use Huifang\Src\Sale\Developer\Infra\Repository\DeveloperRepository;
use Illuminate\Http\Request;

class DeveloperController extends BaseController
{
    public function index(Request $request, DeveloperSearchForm $form)
    {

        $data = [];
        $this->title = '分公司管理';
        $this->file_css = 'pages.company.sale.developer.index';
        $this->file_js = 'pages.company.sale.developer.index';
        //公共部分
        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        //公共部分结束
        $developer_service = new DeveloperService();//需要先建立service
        $data = $developer_service->getDeveloperList($form->developer_specification, 20);
        $appends = $this->getPageAppends($form->developer_specification);
        $data['appends'] = $appends;
        $data['company_id'] = $company_id;
        //省市数据
        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForSale();
        $view = $this->view('pages.company.sale.developer.index', $data);
        return $view;
    }

    public function edit($id)
    {
        $this->title = '分公司管理';
        $this->file_css = 'pages.company.sale.developer.edit';
        $this->file_js = 'pages.company.sale.developer.edit';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        if (!empty($id)) {
            $developer_service = new DeveloperService();
            $data = $developer_service->getDeveloperInfo($id);
        }
        //省市数据
        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForSale();

        $view = $this->view('pages.company.sale.developer.edit', $data);
        return $view;
    }

    public function getPageAppends(DeveloperSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}