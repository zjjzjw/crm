<?php

namespace Huifang\Admin\Src\Forms\Sale\DeveloperGroup;

use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupEntity;
use Huifang\Src\Sale\DeveloperGroup\Infra\Repository\DeveloperGroupRepository;
use Huifang\Web\Src\Forms\Form;

class DeveloperGroupStoreForm extends Form
{

    /**
     * @var DeveloperGroupEntity
     */
    public $developer_group_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'   => 'required|integer',
            'name' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'max'         => ':attribute最大长度',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '集团名称必填',
        ];
    }

    public function validation()
    {

        if (array_get($this->data, 'id')) {
            $developer_group_repository = new DeveloperGroupRepository();
            $this->developer_group_entity = $developer_group_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->developer_group_entity = new DeveloperGroupEntity();
            $this->developer_group_entity->company_id = request()->user()->company_id;
        }
        $this->developer_group_entity->name = array_get($this->data, 'name');

    }

}