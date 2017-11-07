<?php namespace Huifang\Admin\Http\Controllers\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Http\Middleware\RedirectIfAuthenticated;
use Huifang\Admin\Src\Forms\Company\Product\ProductDeleteForm;
use Huifang\Admin\Src\Forms\Company\Product\ProductSearchForm;
use Huifang\Admin\Src\Forms\Company\Product\ProductStoreForm;
use Huifang\Service\Product\ProductCategoryService;
use Huifang\Service\Product\ProductService;
use Huifang\Src\Product\Infra\Repository\ProductCategoryRepository;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Src\Product\Domain\Model\AscriptionType;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request, ProductSearchForm $form)
    {
        $this->title = '产品管理';
        $this->file_css = 'pages.company.product.index';
        $this->file_js = 'pages.company.product.index';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $product_service = new ProductService();
        $data = $product_service->getProductList($form->product_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->product_specification);
        return $this->view('pages.company.product.index', $data);
    }

    public function edit($id)
    {
        $this->title = '产品添加';
        $this->file_css = 'pages.company.product.edit';
        $this->file_js = 'pages.company.product.edit';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;
        $product_service = new ProductService();
        if (!empty($id)) {
            $data = $product_service->getProductInfo($id);
        }
        $ascription_types = AscriptionType::acceptableEnums();
        $data['ascription_types'] = $ascription_types;
        $product_category_service = new ProductCategoryService();
        $categories = $product_category_service->getProductCategoriesByCompanyId($company_id);
        $data['categories'] = $categories;

        $area = $product_service->getProductArea();
        $data['area'] = $area;

        $data['company_id'] = $company_id;
        $data['id'] = $id;

        return $this->view('pages.company.product.edit', $data);
    }


    public function store(Request $request, ProductStoreForm $form)
    {
        $form->validate($request->all());
        $depart_repository = new ProductRepository();
        $depart_repository->save($form->product_entity);
        return redirect()->to(route('company.product.index'));
    }


    public function delete($id, Request $request, ProductDeleteForm $form)
    {
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $product_repository = new ProductRepository();
        $product_repository->delete($id);
        return redirect()->to(route('company.product.index'));

    }

    /**
     * @param ProductSpecification $spec
     * @return array
     */
    public function getPageAppends(ProductSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}
