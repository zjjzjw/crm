<?php namespace Huifang\Web\Http\Controllers\Api\Project;

use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\File\FileDeleteForm;
use Huifang\Web\Src\Forms\Project\File\FileStoreForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Illuminate\Http\Request;


class FileController extends BaseController
{

    /**
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectFileStore(Request $request, FileStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_file_repository = new ProjectFileRepository();
        $project_file_repository->save($form->project_file_entity);
        $data['id'] = $form->project_file_entity->id;
        return response()->json($data, 200);
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectFileDelete($id, Request $request, FileDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_file_repository = new ProjectFileRepository();
        $project_file_repository->delete($id);
        return response()->json($data, 200);
    }

}