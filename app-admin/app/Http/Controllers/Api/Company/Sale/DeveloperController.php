<?php namespace Huifang\Admin\Http\Controllers\Api\Company\Sale;

use Huifang\Service\Sale\Developer\DeveloperService;
use Huifang\Admin\Src\Forms\Sale\Developer\DeveloperSearchForm;
use Huifang\Admin\Src\Forms\Sale\Developer\DeveloperStoreForm;
use Huifang\Admin\Src\Forms\Sale\Developer\DeveloperDeleteForm;
use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;
use Huifang\Src\Sale\Developer\Infra\Repository\DeveloperRepository;
use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class DeveloperController extends BaseController
{
    public function store(Request $request, DeveloperStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $developer_repository = new DeveloperRepository();
        $developer_repository->save($form->developer_entity);
        return response()->json($data, 200);
    }


    public function update(Request $request, DeveloperStoreForm $form)
    {
        return $this->store($request, $form);
    }


    public function delete($id, Request $request, DeveloperDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_repository = new DeveloperRepository();
        $brand_repository->delete($id);
        return response()->json($data, 200);
    }
    public function getDeveloperByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $developer_repository = new DeveloperRepository();
            $developer_entities = $developer_repository->getDeveloperByKeyword($keyword);
            /** @var DeveloperEntity $developer_entity */
            foreach ($developer_entities as $developer_entity) {
                $item = [];
                $item['id'] = $developer_entity->id;
                $item['name'] = $developer_entity->name;
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
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