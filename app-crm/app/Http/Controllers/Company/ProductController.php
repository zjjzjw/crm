<?php namespace Huifang\Crm\Http\Controllers\Company;


use Huifang\Crm\Http\Controllers\BaseController;
use Huifang\Crm\Src\Forms\Company\Product\ProductSearchForm;
use Huifang\Crm\Src\Forms\Company\Product\ProductStoreForm;
use Huifang\Service\Product\ProductService;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Role\Domain\Model\ProductSpecification;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request, $company_id, ProductSearchForm $form)
    {
        $this->title = '公司产品管理';
        $this->file_css = 'pages.company.product.index';
        $this->file_js = 'pages.company.product.index';
        $data = [];
        $request->merge(['company_id' => $company_id]);
        $form->validate($request->all());
        $product_service = new ProductService();
        $data = $product_service->getProductList($form->product_specification, 20);
        $data['company_id'] = $company_id;
        $data['appends'] = $this->getPageAppends($form->product_specification);
        return $this->view('pages.company.product.index', $data);
    }

    public function edit($company_id, $id)
    {
        $this->title = '公司产品管理';
        $this->file_css = 'pages.company.product.edit';
        $this->file_js = 'pages.company.product.edit';
        $data = [];
        if (!empty($id)) {
            $product_service = new ProductService();
            $data = $product_service->getProductInfo($id);
        }
        $data['company_id'] = $company_id;
        $data['id'] = $id;

        return $this->view('pages.company.product.edit', $data);
    }


    public function store(Request $request, ProductStoreForm $form)
    {
        $form->validate($request->all());
        $depart_repository = new ProductRepository();
        $depart_repository->save($form->product_entity);
        return redirect()->to(route('company.product.index', ['company_id' => $form->product_entity->company_id]));
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
