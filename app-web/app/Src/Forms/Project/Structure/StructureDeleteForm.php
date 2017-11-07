<?php

namespace Huifang\Web\Src\Forms\Project\Structure;

use Huifang\Src\Customer\Domain\Model\CustomerEntity;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectStructureEntity;
use Huifang\Src\Project\Domain\Model\StructureType;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Project\Infra\Repository\ProjectStructureRepository;
use Huifang\Web\Src\Forms\Form;

class StructureDeleteForm extends Form
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
        $id = array_get($this->data, 'id');
        $this->validateHasChildren($id);
        $this->validateStructureDelete();
    }


    /**
     * @param int $parent_id
     */
    protected function validateHasChildren($parent_id)
    {
        $project_structure_repository = new ProjectStructureRepository();
        $project_structure_entities =
            $project_structure_repository->getProjectStructureByParentId($parent_id);
        if (!$project_structure_entities->isEmpty()) {
            $this->addError('parent', '请先删除子节点！');
        }
    }

    /**
     * 项目组织架构数据删除权限
     */
    public function validateStructureDelete()
    {
        $id = array_get($this->data, 'id');
        $project_structure_repository = new ProjectStructureRepository();
        /** @var ProjectStructureEntity $project_structure_entity */
        $project_structure_entity = $project_structure_repository->fetch($id);
        $project_id = $project_structure_entity->project_id;

        if ($project_structure_entity->structure_type == StructureType::TYPE_PROJECT) {
            $project_repository = new ProjectRepository();
            /** @var ProjectEntity $project_entity */
            $project_entity = $project_repository->fetch($project_id);
            if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足！');
            }
        } else if ($project_structure_entity->structure_type == StructureType::TYPE_CUSTOMER) {
            $customer_repository = new CustomerRepository();
            /** @var CustomerEntity $customer_entity */
            $customer_entity = $customer_repository->fetch($project_id);
            if (isset($customer_entity) && $customer_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足！');
            }
        }
    }


}