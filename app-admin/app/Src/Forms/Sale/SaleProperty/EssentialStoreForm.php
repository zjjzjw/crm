<?php

namespace Huifang\Admin\Src\Forms\Sale\SaleProperty;

use Huifang\Web\Src\Forms\Form;

class EssentialStoreForm extends Form
{

    /**
     * @var array
     */
    public $sale_data;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'required|integer',
            'project_name'      => 'required|string',
            'loupan_name'       => 'string',
            'record_time'       => 'string',
            'sn'                => 'string',
            'province_id'       => 'integer',
            'county_id'         => 'integer',
            'city_id'           => 'integer',
            'address'           => 'string',
            'developer_id'      => 'integer',
            'project_region_id' => 'integer',
            'sale_status'       => 'integer',
            'user_id'           => 'integer',
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
            'project_name'      => '项目名称',
            'loupan_name'       => '楼盘名称',
            'record_time'       => '备案时间',
            'sn'                => '编号',
            'province_id'       => '省',
            'county_id'         => '县',
            'city_id'           => '城市',
            'address'           => '地址',
            'developer_id'      => '开发商分公司id',
            'project_region_id' => '工程大区划分id',
            'sale_status'       => '销售状态',
            'user_id'           => '负责人',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $data = [];
            $data['id'] = array_get($this->data, 'id');
            $data['sn'] = array_get($this->data, 'sn') ?? '';
            $data['project_name'] = array_get($this->data, 'project_name');
            $data['loupan_name'] = array_get($this->data, 'loupan_name');
            $data['record_time'] = array_get($this->data, 'record_time');
            $data['province_id'] = array_get($this->data, 'province_id');
            $data['county_id'] = array_get($this->data, 'county_id');
            $data['city_id'] = array_get($this->data, 'city_id');
            $data['address'] = array_get($this->data, 'address');
            $data['developer_id'] = array_get($this->data, 'developer_id');
            $data['project_region_id'] = array_get($this->data, 'project_region_id');
            $data['sale_status'] = array_get($this->data, 'sale_status');
            $data['user_id'] = array_get($this->data, 'user_id');

            $this->sale_data = $data;
        }

    }

}