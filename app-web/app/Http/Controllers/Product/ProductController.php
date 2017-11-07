<?php namespace Huifang\Web\Http\Controllers\Product;

use Huifang\Service\Product\ProductCategoryService;
use Huifang\Service\Product\ProductService;
use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


//产品库
class ProductController extends BaseController
{
    //公司列表
    public function companyList()
    {
        $this->title = '公司列表';
        $this->file_css = 'product.company.list';
        $product_service = new ProductService();
        $companies = $product_service->getProductCompanyList();
        $data['companies'] = $companies;
        return $this->view('touch.product.company.list', $data);
    }

    //产品列表
    public function sortsList(Request $request, $company_id, $type)
    {
        $data = [];
        $this->title = '产品列表';
        $this->file_css = 'product.sorts.list';
        $this->file_js = 'product.sorts.list';
        $user = $this->getUser();

        $product_service = new ProductService();
        $spec = new ProductSpecification();
        $spec->ascription = $type;
        $spec->ascription_id = $company_id;
        $spec->category_id = $request->get('category_id', 0);
        $spec->keyword = $request->get('keyword');

        $products = $product_service->getProductsBySpecification($spec);
        $data['products'] = $products;

        $product_category_service = new ProductCategoryService();

        $product_categories = $product_category_service->getProductCategoriesByCompanyId($user->company->id);
        $data['product_categories'] = $product_categories;

        $appends = $this->getPageAppends($spec);
        $data['appends'] = $appends;

        $data['company_id'] = $company_id;
        $data['type'] = $type;

        return $this->view('touch.product.sorts.list', $data);
    }

    //产品详情
    public function detail($id)
    {
        $data = [];
        $this->title = '产品详情';
        $this->file_css = 'product.detail';
        $product_service = new ProductService();
        $data = $product_service->getProductInfo($id);
        $data['id'] = $id;
        return $this->view('touch.product.detail', $data);
    }


    /**
     * 由于路由的问题，名称发生了变化
     * @param ProductSpecification $spec
     * @return  array
     */
    public function getPageAppends(ProductSpecification $spec)
    {
        $appends = [];
        if ($spec->ascription_id) {
            $appends['company_id'] = $spec->ascription_id;
        }
        if ($spec->ascription) {
            $appends['type'] = $spec->ascription;
        }
        if ($spec->category_id) {
            $appends['category_id'] = $spec->category_id;
        }

        return $appends;
    }

}