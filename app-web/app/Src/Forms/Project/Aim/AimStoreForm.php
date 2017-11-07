<?php

namespace Huifang\Web\Src\Forms\Project\Aim;

use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class AimStoreForm extends Form
{

    /**
     * @var ProjectAimEntity
     */
    public $project_aim_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'required|integer',
            'project_id'    => 'required|integer',
            'name'          => 'required|string',
            'pain_analysis' => 'required|string',
            'products'      => 'required|array',
            'other'         => 'string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute是整型',
            'string'      => ':attribute是字符串',
            'numeric'     => ':attribute是数字',
        ];
    }

    public function attributes()
    {
        return [
            'id'            => '主键',
            'project_id'    => '项目ID',
            'name'          => '名称',
            'pain_analysis' => '痛点分析',
            'products'      => '产品必选',
            'other'         => '其他',
        ];
    }

    public function validation()
    {
        if (!empty(array_get($this->data, 'id'))) {
            $project_aim_repository = new ProjectAimRepository();
            $project_aim_entity = $project_aim_repository->fetch(array_get($this->data, 'id'));
        } else {
            $project_aim_entity = new ProjectAimEntity();
            $project_aim_entity->product_ids = '';
            $project_aim_entity->volume = 0;
            $project_aim_entity->price = 0;
        }

        $project_aim_entity->project_id = array_get($this->data, 'project_id');
        $project_aim_entity->name = array_get($this->data, 'name');
        $project_aim_entity->pain_analysis = array_get($this->data, 'pain_analysis');
        $project_aim_entity->other = array_get($this->data, 'other');
        $project_aim_entity->products = $this->formatDataFromHorToVert(array_get($this->data, 'products'));

        $this->validateProjectAimEdit();
        $this->project_aim_entity = $project_aim_entity;
    }

    /**
     * 目标编辑权限判断
     */
    public function validateProjectAimEdit()
    {
        $project_id = array_get($this->data, 'project_id');
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足');
        }
    }
}