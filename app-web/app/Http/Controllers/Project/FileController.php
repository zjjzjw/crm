<?php namespace Huifang\Web\Http\Controllers\project;

use Huifang\Service\Project\ProjectFileService;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class FileController extends BaseController
{
    public function fileEdit(Request $request, $project_id, $id)
    {
        $this->file_css = 'project.file.edit';
        $this->file_js = 'project.file.edit';
        $this->title = '项目档案';
        $user = $this->getUser();
        $project_file_service = new ProjectFileService();
        $data = $project_file = $project_file_service->getProjectFileInfo($id);

        $data['project_id'] = $project_id;
        $data['id'] = $id;
        return $this->view('touch.project.file.edit', $data);
    }

    public function fileDetail(Request $request, $project_id, $id)
    {
        $data = [];
        $this->file_css = 'project.file.detail';
        $this->file_js = 'project.file.detail';
        $this->title = '项目档案';
        $user = $this->getUser();

        $project_file_service = new ProjectFileService();
        $data = $project_file_service->getProjectFileInfo($id);
        $data['project_id'] = $project_id;
        $data['id'] = $id;


        return $this->view('touch.project.file.detail', $data);
    }

    public function file(Request $request, $project_id)
    {
        $project_file_repository = new ProjectFileRepository();
        $project_file_entity = $project_file_repository->getProjectFileByProjectId($project_id);
        if (isset($project_file_entity)) {
            return redirect()->to(route('project.file.detail',
                ['project_id' => $project_id, 'id' => $project_file_entity->id]));
        } else {
            return redirect()->to(route('project.file.edit',
                ['project_id' => $project_id, 'id' => 0]));
        }
    }


}