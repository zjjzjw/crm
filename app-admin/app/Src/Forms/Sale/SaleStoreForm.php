<?php

namespace Huifang\Admin\Src\Forms\Sale;

use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;

class SaleStoreForm extends Form
{

    /**
     * @var SaleEntity
     */
    public $sale_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                   => 'required|integer',
            'project_name'         => 'required|string',
            'sn'                   => 'string',
            'province_id'          => 'integer',
            'city_id'              => 'integer',
            'county_id'            => 'integer',
            'address'              => 'string',
            'developer_name'       => 'string',
            'developer_group_name' => 'string',
            'project_volume'       => 'integer',
            'project_step_id'      => 'integer',
            'contact_name'         => 'string',
            'position_name'        => 'string',
            'contact_phone'        => 'string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
        ];
    }

    public function attributes()
    {
        return [
            'project_name'         => '楼盘名称',
            'province_id'          => '省',
            'city_id'              => '城市',
            'address'              => '地址',
            'developer_name'       => '开发商',
            'developer_group_name' => '所属集团',
            'project_volume'       => '精装总用户',
            'project_step_id'      => '项目阶段',
            'contact_name'         => '联系人',
            'position_name'        => '岗位',
            'contact_phone'        => '电话',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $sale_repository = new SaleRepository();
            $this->sale_entity = $sale_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->sale_entity = new SaleEntity();
            $this->sale_entity->company_id = request()->user()->company->id;
        }
        $this->sale_entity->sn = array_get($this->data, 'sn');
        $this->sale_entity->project_name = array_get($this->data, 'project_name');
        $this->sale_entity->province_id = array_get($this->data, 'province_id');
        $this->sale_entity->city_id = array_get($this->data, 'city_id');
        $this->sale_entity->address = array_get($this->data, 'address');
        $this->sale_entity->county_id = array_get($this->data, 'county_id') ?? 0;
        $this->sale_entity->developer_name = array_get($this->data, 'developer_name');
        $this->sale_entity->developer_group_name = array_get($this->data, 'developer_group_name');
        $this->sale_entity->project_volume = array_get($this->data, 'project_volume');
        $this->sale_entity->project_step_id = array_get($this->data, 'project_step_id');
        $this->sale_entity->contact_name = array_get($this->data, 'contact_name');
        $this->sale_entity->position_name = array_get($this->data, 'position_name');
        $this->sale_entity->contact_phone = array_get($this->data, 'contact_phone');

    }

}