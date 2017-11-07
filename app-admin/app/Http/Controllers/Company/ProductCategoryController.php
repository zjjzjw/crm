<?php namespace Huifang\Admin\Http\Controllers\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\Product\ProductCategoryDeleteForm;
use Huifang\Admin\Src\Forms\Company\Product\ProductCategorySearchForm;
use Huifang\Admin\Src\Forms\Company\Product\ProductCategoryStoreForm;
use Huifang\Service\Product\ProductCategoryService;
use Huifang\Src\Product\Domain\Model\ProductCategorySpecification;
use Huifang\Src\Product\Infra\Repository\ProductCategoryRepository;
use Illuminate\Http\Request;


class ProductCategoryController extends BaseController
{
    public function index(Request $request, ProductCategorySearchForm $form)
    {
        $this->title = '产品分类';
        $this->file_css = 'pages.company.product.category.index';
        $this->file_js = 'pages.company.product.category.index';
        $data = [];
        $user = $this->getUser();
        $company_id = $user->company->id;

        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());

        $product_category_service = new ProductCategoryService();
        $data = $product_category_service->getProductCategoryList($form->product_category_specification, 20);

        $appends = $this->getPageAppends($form->product_category_specification);
        $data['appends'] = $appends;

        $data['company_id'] = $company_id;
        return $this->view('pages.company.product.category.index', $data);
    }

    public function edit($id)
    {
        $this->title = '产品分类-编辑';
        $this->file_css = 'pages.company.product.category.edit';
        $this->file_js = 'pages.company.product.category.edit';
        $data = [];



        $user = $this->getUser();
        $company_id = $user->company->id;
        if (!empty($id)) {
            $product_category_service = new ProductCategoryService();
            $data = $product_category_service->getProductCategoryInfo($id);
        }
        $data['company_id'] = $company_id;
        return $this->view('pages.company.product.category.edit', $data);
    }

    public function store(Request $request, ProductCategoryStoreForm $form)
    {
        $form->validate($request->all());
        $product_category_repository = new ProductCategoryRepository();
        $product_category_repository->save($form->product_category_entity);
        return redirect()->to(route('company.product.category.index'));
    }

    /**
     * @param int                       $id
     * @param Request                   $request
     * @param ProductCategoryDeleteForm $form
     */
    public function delete($id, Request $request, ProductCategoryDeleteForm $form)
    {
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $product_category_repository = new ProductCategoryRepository();
        $product_category_repository->delete($id);
        return redirect()->to(route('company.product.category.index'));
    }

    /**
     * @param ProductCategorySpecification $spec
     * @return array
     */
    public function getPageAppends(ProductCategorySpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }


}