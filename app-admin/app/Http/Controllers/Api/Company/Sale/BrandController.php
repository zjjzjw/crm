<?php namespace Huifang\Admin\Http\Controllers\Api\Company\Sale;

use Huifang\Service\Sale\Brand\BrandService;
use Huifang\Admin\Src\Forms\Sale\Brand\BrandSearchForm;
use Huifang\Admin\Src\Forms\Sale\Brand\BrandStoreForm;
use Huifang\Admin\Src\Forms\Sale\Brand\BrandDeleteForm;
use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;
use Huifang\Src\Sale\Brand\Infra\Repository\BrandRepository;
use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    public function store(Request $request, BrandStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $brand_repository = new BrandRepository();
        $brand_repository->save($form->brand_entity);
        return response()->json($data, 200);
    }

    public function update(Request $request, BrandStoreForm $form)
    {
        return $this->store($request, $form);
    }

    public function delete($id, Request $request, BrandDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_repository = new BrandRepository();
        $brand_repository->delete($id);
        return response()->json($data, 200);

    }
    public function keyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword');
        if ($keyword) {
            $brand_repository = new BrandRepository();
            $brand_entities = $brand_repository->getBrandListByBrandName($keyword);
            /** @var BrandEntity $brand_entity */
            foreach ($brand_entities as $brand_entity) {
                $brand = $brand_entity->toArray();
                $item['id'] = $brand['id'];
                $item['name'] = $brand['brand_name'];
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
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