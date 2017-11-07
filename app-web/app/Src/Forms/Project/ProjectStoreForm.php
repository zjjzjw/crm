<?php

namespace Huifang\Web\Src\Forms\Project;

use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class ProjectStoreForm extends Form
{

    /**
     * @var ProjectEntity
     */
    public $project_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    => 'required|integer',
            'project_name'          => 'required|string',
            'province_id'           => 'required|integer',
            'city_id'               => 'required|integer',
            'address'               => 'required|string',
            'developer_name'        => 'required|string',
            'project_volume'        => 'required|integer',
            'signed_at'             => 'required|string|date_format:Y-m-d',
            'contact_name'          => 'required|string',
            'project_corp_user_ids' => 'string',
            'user_id'               => 'integer',
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
            'id'                   => '主键',
            'project_name'         => '项目名称',
            'province_id'          => '省份',
            'city_id'              => '城市',
            'address'              => '详细地址',
            'developer_name'       => '所属开发商',
            'project_volume'       => '体量',
            'contact_name'         => '联系人名称',
            'cooperation_user_ids' => '合伙人',
            'use_brands'           => '使用品牌',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $id = array_get($this->data, 'id');
            $project_repository = new ProjectRepository();
            $project_entity = $project_repository->fetch($id);

            //但是编辑的时候，可修改项目的负责人
            $project_entity->user_id = array_get($this->data, 'user_id');
        } else {
            $project_entity = new ProjectEntity();
            //得到创建者
            $project_entity->created_user_id = request()->user()->id;
            $project_entity->user_id = request()->user()->id;
            $project_entity->company_id = request()->user()->company_id;
        }
        $project_entity->project_name = array_get($this->data, 'project_name');
        $project_entity->province_id = array_get($this->data, 'province_id');
        $project_entity->city_id = array_get($this->data, 'city_id');
        $project_entity->address = array_get($this->data, 'address');
        $project_entity->developer_name = array_get($this->data, 'developer_name');
        $project_entity->contact_name = array_get($this->data, 'contact_name');
        $project_entity->project_volume = array_get($this->data, 'project_volume');
        $project_entity->contact_phone = '';
        $project_entity->use_brands = array_get($this->data, 'use_brands', ''); //使用品牌默认为空
        $project_entity->signed_at = $this->validateDate('signed_at', array_get($this->data, 'signed_at'));

        if (!empty(array_get($this->data, 'project_corp_user_ids'))) {
            $project_entity->project_corp_user_ids = explode(',', array_get($this->data, 'project_corp_user_ids'));
        }
        $this->validateProjectEdit();
        $this->project_entity = $project_entity;
    }

    /**
     * 判断项目的编辑权限
     */
    public function validateProjectEdit()
    {
        $project_repository = new ProjectRepository();
        if (array_get($this->data, 'id')) {
            /** @var ProjectEntity $project_entity */
            $project_entity = $project_repository->fetch(array_get($this->data, 'id'));
            if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足！');
            }
        }
    }

}