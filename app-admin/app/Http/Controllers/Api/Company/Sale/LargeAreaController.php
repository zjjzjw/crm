<?php namespace Huifang\Admin\Http\Controllers\Api\Company\Sale;

use Huifang\Service\Sale\DeveloperGroup\DeveloperGroupService;
use Huifang\Admin\Src\Forms\Sale\LargeArea\LargeAreaSearchForm;
use Huifang\Admin\Src\Forms\Sale\LargeArea\LargeAreaStoreForm;
use Huifang\Admin\Src\Forms\Sale\LargeArea\LargeAreaDeleteForm;
use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;
use Huifang\Src\Sale\LargeArea\Infra\Repository\LargeAreaRepository;
use Huifang\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class LargeAreaController extends BaseController
{
    public function store(Request $request, LargeAreaStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $largeArea_repository = new LargeAreaRepository();
        $largeArea_repository->save($form->largeArea_entity);
        return response()->json($data, 200);
    }


    public function update(Request $request, LargeAreaStoreForm $form)
    {
        return $this->store($request, $form);
    }


    public function delete($id, Request $request, LargeAreaDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $largeArea_repository = new LargeAreaRepository();
        $largeArea_repository->delete($id);
        return response()->json($data, 200);

    }

    public function getPageAppends(LargeAreaSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}