<?php

namespace Huifang\Web\Src\Forms\Project\File;

use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class FileDeleteForm extends Form
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
        $this->validateProjectFileDelete();
    }

    /**
     * 项目档案的编辑权限判断
     */
    protected function validateProjectFileDelete()
    {
        $id = array_get($this->data, 'id');
        $project_file_repository = new ProjectFileRepository();
        /** @var ProjectFileEntity $project_file_entity */
        $project_file_entity = $project_file_repository->fetch($id);
        $project_id = $project_file_entity->project_id;
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}