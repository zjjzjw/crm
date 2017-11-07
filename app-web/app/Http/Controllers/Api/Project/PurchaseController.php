<?php namespace Huifang\Web\Http\Controllers\Api\Project;

use Huifang\Src\Project\Domain\Model\ProjectPurchaseEntity;
use Huifang\Src\Project\Infra\Repository\ProjectPurchaseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectStructureRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\Purchase\PurchaseDeleteForm;
use Huifang\Web\Src\Forms\Project\Purchase\PurchaseStoreForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Illuminate\Http\Request;


class PurchaseController extends BaseController
{

    /**
     * @param Request           $request
     * @param PurchaseStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectPurchaseStore(Request $request, PurchaseStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_purchase_repository = new ProjectPurchaseRepository();
        $project_purchase_repository->save($form->project_purchase_entity);
        return response()->json($data, 200);
    }


    public function projectPurchaseDelete($id, Request $request, PurchaseDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_purchase_repository = new ProjectPurchaseRepository();
        $project_purchase_repository->delete($id);
        return response()->json($data, 200);
    }
}