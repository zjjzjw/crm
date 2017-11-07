<?php

namespace Huifang\Web\Src\Forms\Project\Aim;

use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAimHinderRepository;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class AimHinderDeleteForm extends Form
{
    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
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
            'id' => '主键',
        ];
    }

    public function validation()
    {
        $this->validateProjectAimHinderDelete();
    }

    /**
     * 目标障碍删除数据权限
     */
    public function validateProjectAimHinderDelete()
    {
        $id = array_get($this->data, 'id');
        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        /** @var ProjectAimHinderEntity $project_aim_hinder_entity */
        $project_aim_hinder_entity = $project_aim_hinder_repository->fetch($id);
        $project_id = $project_aim_hinder_entity->project_id;
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }
}