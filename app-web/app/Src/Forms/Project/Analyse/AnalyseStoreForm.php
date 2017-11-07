<?php

namespace Huifang\Web\Src\Forms\Project\Analyse;

use Huifang\Src\Project\Domain\Model\ProjectAnalyseEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAnalyseRepository;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class AnalyseStoreForm extends Form
{

    /**
     * @var ProjectAnalyseEntity
     */
    public $project_analyse_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'           => 'required|integer',
            'project_id'   => 'required|integer',
            'event_desc'   => 'required|string',
            'analyse_type' => 'required|integer',
            'swot_type'    => 'required|integer',
        ];
    }


    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute是整型',
            'string'      => ':attribute是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id'           => '主键',
            'project_id'   => '项目ID',
            'event_desc'   => '事件描述',
            'analyse_type' => '优劣势类别',
            'swot_type'    => '优劣势类型',
        ];
    }

    public function validation()
    {
        if (!empty(array_get($this->data, 'id'))) {
            $project_analyse_repository = new ProjectAnalyseRepository();
            $project_analyse_entity = $project_analyse_repository->fetch(array_get($this->data, 'id'));
        } else {
            $project_analyse_entity = new ProjectAnalyseEntity();
        }
        $project_analyse_entity->project_id = array_get($this->data, 'project_id');
        $project_analyse_entity->event_desc = array_get($this->data, 'event_desc');
        $project_analyse_entity->analyse_type = array_get($this->data, 'analyse_type');
        $project_analyse_entity->swot_type = array_get($this->data, 'swot_type');

        $this->validateProjectAnalyseEdit();
        $this->project_analyse_entity = $project_analyse_entity;
    }

    /**
     * 优劣势分析权限判断
     */
    public function validateProjectAnalyseEdit()
    {
        $project_id = array_get($this->data, 'project_id');
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}