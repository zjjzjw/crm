<?php namespace Huifang\Web\Http\Controllers\Api\Project;

use Huifang\Service\Project\ProjectService;
use Huifang\Service\Sale\SaleService;

use Huifang\Src\Project\Infra\Repository\ProjectAnalyseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\Analyse\AnalyseDeleteForm;
use Huifang\Web\Src\Forms\Project\Analyse\AnalyseStoreForm;
use Huifang\Web\Src\Forms\Project\File\FileStoreForm;
use Huifang\Web\Src\Forms\Project\ProjectSearchForm;
use Huifang\Web\Src\Forms\Project\ProjectStoreForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Illuminate\Http\Request;


class AnalyseController extends BaseController
{


    /**
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectAnalyseStore(Request $request, AnalyseStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_analyse_repository = new ProjectAnalyseRepository();
        $project_analyse_repository->save($form->project_analyse_entity);
        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectAnalyseDelete($id, Request $request, AnalyseDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_analyse_repository = new ProjectAnalyseRepository();
        $project_analyse_repository->delete($id);
        return response()->json($data, 200);
    }

}