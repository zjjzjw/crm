<?php

namespace Huifang\Web\Src\Forms\Project\Structure;

use Huifang\Src\Customer\Domain\Model\CustomerEntity;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectStructureEntity;
use Huifang\Src\Project\Domain\Model\StructureRoleType;
use Huifang\Src\Project\Domain\Model\StructureType;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Project\Infra\Repository\ProjectStructureRepository;
use Huifang\Web\Src\Forms\Form;

class StructureStoreForm extends Form
{

    /**
     * @var ProjectStructureEntity
     */
    public $project_structure_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                 => 'required|integer',
            'project_id'         => 'required|integer',
            'parent_id'          => 'required|integer',
            'name'               => 'required|string',
            'position_name'      => 'required|string',
            'contact_phone'      => 'required|string',
            'structure_role_id'  => 'required|integer',
            'current_related_id' => 'required|integer',
            'character'          => 'required|array',
            'interest'           => 'required|string',
            'breakthrough_plan'  => 'required|string',
            'feedback'           => 'integer',
            'proof'              => 'required|string',
            'pain_desc'          => 'required|string',
            'support_type'       => 'required|integer',
            'structure_type'     => 'required|integer',
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
            'id'                 => '主键',
            'project_id'         => '项目ID',
            'parent_id'          => '父节点ID',
            'name'               => '任务名称',
            'position_name'      => '职位名称',
            'structure_role_id'  => '角色',
            'current_related_id' => '现阶段关系',
            'character'          => '性格',
            'interest'           => '兴趣点',
            'breakthrough_plan'  => '突破计划',
            'feedback'           => '结果反馈',
            'proof'              => '举证',
            'pain_desc'          => '痛苦描述',
            'support_type'       => '支持与反对',
            'structure_type'     => '结构类型',
        ];
    }

    public function validation()
    {

        if (!empty(array_get($this->data, 'id'))) {
            $project_structure_repository = new ProjectStructureRepository();
            $project_structure_entity = $project_structure_repository->fetch(array_get($this->data, 'id'));
        } else {
            $project_structure_entity = new ProjectStructureEntity();
        }

        $project_structure_entity->project_id = array_get($this->data, 'project_id');
        $project_structure_entity->parent_id = array_get($this->data, 'parent_id');
        $project_structure_entity->name = array_get($this->data, 'name');
        $project_structure_entity->position_name = array_get($this->data, 'position_name');
        $project_structure_entity->contact_phone = array_get($this->data, 'contact_phone');
        $project_structure_entity->structure_role_id = array_get($this->data, 'structure_role_id');
        $project_structure_entity->current_related_id = array_get($this->data, 'current_related_id');
        $project_structure_entity->character = implode(';', array_get($this->data, 'character', []));
        $project_structure_entity->interest = array_get($this->data, 'interest');
        $project_structure_entity->breakthrough_plan = array_get($this->data, 'breakthrough_plan');
        $project_structure_entity->feedback = array_get($this->data, 'feedback', 0);
        $project_structure_entity->proof = array_get($this->data, 'proof');
        $project_structure_entity->pain_desc = array_get($this->data, 'pain_desc');
        $project_structure_entity->support_type = array_get($this->data, 'support_type');
        $project_structure_entity->structure_type = array_get($this->data, 'structure_type');

        $this->validateProjectStructureEdit();

        $this->project_structure_entity = $project_structure_entity;

    }

    /**
     * 验证组织结构编辑权限
     */
    public function validateProjectStructureEdit()
    {
        $project_id = array_get($this->data, 'project_id');
        if (array_get($this->data, 'structure_type') == StructureType::TYPE_PROJECT) {
            $project_repository = new ProjectRepository();
            /** @var ProjectEntity $project_entity */
            $project_entity = $project_repository->fetch($project_id);
            if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足！');
            }
        } else if (array_get($this->data, 'structure_type') == StructureType::TYPE_CUSTOMER) {
            $customer_repository = new CustomerRepository();
            /** @var CustomerEntity $customer_entity */
            $customer_entity = $customer_repository->fetch($project_id);
            if (isset($customer_entity) && $customer_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足!');
            }
        }
    }


}