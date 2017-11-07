<?php namespace Huifang\Admin\Http\Controllers\Api\Company\Sale;

use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\BuildingStoreForm;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\EssentialStoreForm;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\FollowStoreForm;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\OtherStoreForm;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\PropertyStoreForm;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\SalePropertyDeleteForm;
use Huifang\Admin\Src\Forms\Sale\SaleProperty\SaleStoreForm;
use Huifang\Service\Sale\SaleService;
use Huifang\Src\Sale\Infra\Repository\SalePropertyRepository;
use Illuminate\Http\Request;

class SalePropertyController extends BaseController
{
    public function essentialStore(Request $request, EssentialStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->saveSaleProperty($form->sale_data);
        return response()->json($data, 200);
    }

    public function buildingStore(Request $request, BuildingStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->saveSaleProperty($form->sale_data);
        return response()->json($data, 200);
    }

    public function propertyStore(Request $request, PropertyStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->saveSaleProperty($form->sale_data);
        return response()->json($data, 200);
    }

    public function saleStore(Request $request, SaleStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->saveSaleProperty($form->sale_data);
        return response()->json($data, 200);
    }

    public function followStore(Request $request, FollowStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->saveSaleProperty($form->sale_data);
        return response()->json($data, 200);
    }

    public function otherStore(Request $request, OtherStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_service = new SaleService();
        $sale_service->saveSaleProperty($form->sale_data);
        return response()->json($data, 200);
    }

    public function delete($id, Request $request, SalePropertyDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $sale_property_repository = new SalePropertyRepository();
        $sale_property_repository->delete($id);
        return response()->json($data, 200);

    }

}