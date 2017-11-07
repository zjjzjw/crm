<?php

namespace Huifang\Mobi\Src\Forms\Project;

use Huifang\Service\Role\TokenService;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class ProjectDeleteForm extends Form
{

    public $id;
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
        ];
    }

    public function attributes()
    {
        return [
            'id' => '项目ID',
        ];
    }


    public function validation()
    {
        $this->validateProjectDelete();
    }


    /**
     * 项目删除的数据权限
     */
    public function validateProjectDelete()
    {
        $id = array_get($this->data, 'id');
        $this->id = $id;
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($id);
        if (isset($project_entity) && $project_entity->user_id != TokenService::$user_id) {
            $this->addError('permission', '权限不足！');
        }
    }

}