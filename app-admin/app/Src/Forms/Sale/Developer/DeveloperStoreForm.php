<?php

namespace Huifang\Admin\Src\Forms\Sale\Developer;

use Huifang\Src\Sale\Developer\Domain\Model\DeveloperEntity;
use Huifang\Src\Sale\Developer\Infra\Repository\DeveloperRepository;
use Huifang\Web\Src\Forms\Form;

class DeveloperStoreForm extends Form
{

    /**
     * @var DeveloperEntity
     */
    public $developer_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'id'   => 'required|integer',
            'province_id' => 'required|string',
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
            'province_id' => '省份名称',
            "city_id"=>"城市名称",
            "name"=>"分公司名称",
        ];
    }
    public function validation()
    {

        if (array_get($this->data, 'id')) {
            $developer_repository = new DeveloperRepository();
            $this->developer_entity = $developer_repository->fetch(array_get($this->data, 'id'));
        }else {
            $this->developer_entity = new DeveloperEntity();
            $this->developer_entity->company_id = request()->user()->company_id;

        }
        $this->developer_entity->province_id = array_get($this->data, 'province_id');
        $this->developer_entity->city_id = array_get($this->data,'city_id');
        $this->developer_entity->name = array_get($this->data,'name');
    }

}