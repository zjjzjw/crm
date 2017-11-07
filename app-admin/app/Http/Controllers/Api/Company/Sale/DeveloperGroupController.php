<?php namespace Huifang\Admin\Http\Controllers\Api\Company\Sale;

use Huifang\Service\Sale\DeveloperGroup\DeveloperGroupService;
use Huifang\Admin\Src\Forms\Sale\DeveloperGroup\DeveloperSearchForm;
use Huifang\Admin\Src\Forms\Sale\DeveloperGroup\DeveloperGroupStoreForm;
use Huifang\Admin\Src\Forms\Sale\DeveloperGroup\DeveloperGroupDeleteForm;
use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;
use Huifang\Src\Sale\DeveloperGroup\Infra\Repository\DeveloperGroupRepository;
use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class DeveloperGroupController extends BaseController
{
    public function store(Request $request, DeveloperGroupStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $developerGroup_repository = new DeveloperGroupRepository();
        $developerGroup_repository->save($form->developer_group_entity);
        return response()->json($data, 200);
    }


    public function update(Request $request, DeveloperGroupStoreForm $form)
    {
        return $this->store($request, $form);
    }


    public function delete($id, Request $request, DeveloperGroupDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $developerGroup_repository = new DeveloperGroupRepository();
        $developerGroup_repository->delete($id);
        return response()->json($data, 200);
    }
    public function getDeveloperGroupByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $developer_group_repository = new DeveloperGroupRepository();
            $developer_group_entities = $developer_group_repository->getDeveloperGroupByKeyword($keyword);
            /** @var DeveloperGroupEntity $developer_group_entitie */
            foreach ($developer_group_entities as $developer_group_entitie) {
                $item = [];
                $item['id'] = $developer_group_entitie->id;
                $item['name'] = $developer_group_entitie->name;
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }

    public function getPageAppends(DeveloperGroupSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}