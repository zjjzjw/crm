<?php

namespace Huifang\Web\Src\Forms\Project\Aim;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAimHinderRepository;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class AimHinderStoreForm extends Form
{

    /**
     * @var ProjectAimHinderEntity
     */
    public $project_aim_hinder_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                   => 'required|integer',
            'project_id'           => 'required|integer',
            'aim_id'               => 'required|integer',
            'hinder_name'          => 'required|string',
            'implementation_plan'  => 'required|string',
            'project_purchase_id'  => 'required|integer',
            'feedback'             => 'required|string',
            'status'               => 'required|integer',
            'resource_application' => 'required|string',
            'executed_at'          => 'required|string|date_format:Y-m-d,',

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
            'id'                   => '主键',
            'project_id'           => '项目ID',
            'aim_id'               => '目标ID',
            'hinder_name'          => '障碍名称',
            'implementation_plan'  => '执行计划',
            'project_purchase_id'  => '采购ID',
            'feedback'             => '反馈',
            'status'               => '状态',
            'executed_at'          => '执行时间',
            'resource_application' => '资源申请',
        ];
    }

    public function validation()
    {
        if (!empty(array_get($this->data, 'id'))) {
            $project_aim_hinder_repository = new ProjectAimHinderRepository();
            $project_aim_hinder_entity = $project_aim_hinder_repository->fetch(array_get($this->data, 'id'));
        } else {
            $project_aim_hinder_entity = new ProjectAimHinderEntity();
        }
        $project_aim_hinder_entity->project_id = array_get($this->data, 'project_id');
        $project_aim_hinder_entity->aim_id = array_get($this->data, 'aim_id');
        $project_aim_hinder_entity->implementation_plan = array_get($this->data, 'implementation_plan');
        $project_aim_hinder_entity->project_purchase_id = array_get($this->data, 'project_purchase_id');
        $project_aim_hinder_entity->hinder_name = array_get($this->data, 'hinder_name');
        $project_aim_hinder_entity->feedback = array_get($this->data, 'feedback');
        $project_aim_hinder_entity->status = array_get($this->data, 'status');
        $project_aim_hinder_entity->executed_at = Carbon::parse(array_get($this->data, 'executed_at'));
        $project_aim_hinder_entity->resource_application = array_get($this->data, 'resource_application');

        $this->validateProjectAimHinderEdit();
        $this->project_aim_hinder_entity = $project_aim_hinder_entity;
    }


    /**
     * 目标障碍编辑权限
     */
    public function validateProjectAimHinderEdit()
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