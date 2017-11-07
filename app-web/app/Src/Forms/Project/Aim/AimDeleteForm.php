<?php

namespace Huifang\Web\Src\Forms\Project\Aim;

use Huifang\Src\Project\Domain\Model\ProjectAimEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class AimDeleteForm extends Form
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
        $this->validateProjectAimDelete();
    }

    /**
     * 目标编辑权限判断
     */
    public function validateProjectAimDelete()
    {
        $id = array_get($this->data, 'id');
        $project_aim_repository = new ProjectAimRepository();
        /** @var ProjectAimEntity $project_aim_entity */
        $project_aim_entity = $project_aim_repository->fetch($id);
        $project_id = $project_aim_entity->project_id;
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }
}