<?php namespace Huifang\Web\Http\Controllers\Api\Project;

use Huifang\Service\Project\ProjectService;
use Huifang\Service\Sale\SaleService;

use Huifang\Src\Project\Infra\Repository\ProjectAnalyseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Project\Infra\Repository\ProjectStructureRepository;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\Analyse\AnalyseStoreForm;
use Huifang\Web\Src\Forms\Project\File\FileStoreForm;
use Huifang\Web\Src\Forms\Project\ProjectSearchForm;
use Huifang\Web\Src\Forms\Project\ProjectStoreForm;
use Huifang\Web\Src\Forms\Project\Structure\StructureDeleteForm;
use Huifang\Web\Src\Forms\Project\Structure\StructureStoreForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Illuminate\Http\Request;


class StructureController extends BaseController
{


    /**
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectStructureStore(Request $request, StructureStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_structure_repository = new ProjectStructureRepository();
        $project_structure_repository->save($form->project_structure_entity);
        return response()->json($data, 200);
    }

    /**
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectStructureDelete($id, Request $request, StructureDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_structure_repository = new ProjectStructureRepository();
        $project_structure_repository->delete($id);
        return response()->json($data, 200);
    }

}