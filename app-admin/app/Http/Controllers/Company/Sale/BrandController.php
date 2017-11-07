<?php namespace Huifang\Admin\Http\Controllers\Company\Sale;

use Huifang\Service\Sale\Brand\BrandService;
use Huifang\Admin\Src\Forms\Sale\Brand\BrandSearchForm;
use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;
use Huifang\Src\Sale\Brand\Infra\Repository\BrandRepository;
use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class BrandController extends BaseController
{

    public function index(Request $request, BrandSearchForm $form)
    {
        $this->title = '品牌管理';
        $this->file_css = 'pages.company.sale.brand.index';
        $this->file_js = 'pages.company.sale.brand.index';
        $data = [];
        //公共部分
        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        //公共部分结束
        $band_service = new BrandService();//需要先建立service
        $data = $band_service->getBrandList($form->brand_specification, 20);
        $appends = $this->getPageAppends($form->brand_specification);
        $data['appends'] = $appends;

        $view = $this->view('pages.company.sale.brand.index', $data);
        return $view;
    }

    public function edit($id)
    {
        $this->title = '品牌管理';
        $this->file_css = 'pages.company.sale.brand.edit';
        $this->file_js = 'pages.company.sale.brand.edit';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        if (!empty($id)) {
            $brand_service = new BrandService();
            $data = $brand_service->getBrandInfo($id);
        }
        $data['company_id'] = $company_id;
        $view = $this->view('pages.company.sale.brand.edit', $data);
        return $view;
    }

    public function getPageAppends(BrandSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}