<?php namespace Huifang\Web\Http\Controllers\project;

use Huifang\Service\Project\ProjectAnalyseService;
use Huifang\Src\Project\Domain\Model\SwotType;
use Huifang\Web\Http\Controllers\BaseController;


class AnalyseController extends BaseController
{
    /**
     * @param  int $id 项目ID
     * @return mixed
     */
    public function analyseDetail($project_id)
    {
        $data = [];
        $this->file_css = 'project.analyse.detail';
        $this->file_js = 'project.analyse.detail';
        $this->title = '优劣势分析';
        $project_analyse_service = new ProjectAnalyseService();
        $data = $project_analyse_service->getProjectAnalyse($project_id);
        $data['project_id'] = $project_id;
        return $this->view('touch.project.analyse.detail', $data);
    }

    /**
     * @param  int $project_id 项目ID
     * @param  int $type 类型
     * @return mixed
     */
    public function analyseCommonList($project_id, $type)
    {
        $data = [];
        $this->file_css = 'project.analyse.common-list';
        $this->file_js = 'project.analyse.common-list';
        $this->title = '优劣势分析';
        $data['project_id'] = $project_id;
        $data['type'] = $type;
        $project_analyse_service = new ProjectAnalyseService();
        $project_analyses = $project_analyse_service->getProjectAnalyseByProjectIdAndType($project_id, $type);
        $data['project_analyses'] = $project_analyses;
        $this->title = $project_analyse_service->getAnalyseTile($type) . '列表';
        return $this->view('touch.project.analyse.common-list', $data);
    }

    /**
     * @param  int $project_id 项目ID
     * @param  int $id 项目ID
     * @return mixed
     */
    public function analyseCommonDetail($project_id, $id)
    {
        $data = [];
        $this->file_css = 'project.analyse.common-detail';
        $this->file_js = 'project.analyse.common-detail';
        $this->title = '优劣势分析';

        $project_analyse_service = new ProjectAnalyseService();
        $data = $project_analyse_service->getProjectAnalyseInfo($id);
        $data['project_id'] = $project_id;
        $data['id'] = $id;
        $this->title = $data['analyse_type_name'] . '详情';
        return $this->view('touch.project.analyse.common-detail', $data);
    }

    /**
     * @param int $project_id
     * @param int $type
     * @return  mixed
     */
    public function analyseCommonEdit($project_id, $type, $id)
    {
        $this->file_css = 'project.analyse.common-edit';
        $this->file_js = 'project.analyse.common-edit';
        $this->title = '优劣势分析';
        $project_analyse_service = new ProjectAnalyseService();
        $data = [];
        if (!empty($id)) {
            $data = $project_analyse_service->getProjectAnalyseInfo($id);
            $this->title = '编辑' . $project_analyse_service->getAnalyseTile($type);
        } else {
            $this->title = '添加' . $project_analyse_service->getAnalyseTile($type);
        }
        $swot_types = SwotType::acceptableEnums();
        $data['swot_types'] = $swot_types;

        $data['id'] = $id;
        $data['type'] = $type;
        $data['project_id'] = $project_id;


        return $this->view('touch.project.analyse.common-edit', $data);
    }


}