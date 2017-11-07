<?php

namespace Huifang\Admin\Src\Forms\Sale\SaleProperty;

use Huifang\Web\Src\Forms\Form;

class SaleStoreForm extends Form
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
            'id'               => 'required|integer',
            'housing_price'    => 'string',
            'has_sample_house' => 'integer',
            'brand_id'         => 'integer',
            'opening_time'     => 'string',
            'handing_time'     => 'string',
            'sale_phone'       => 'string',
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
            'housing_price'    => '楼盘均价',
            'has_sample_house' => '是否有样板房',
            'brand_id'         => '样板配套品牌',
            'opening_time'     => '开盘时间',
            'handing_time'     => '交房时间',
            'sale_phone'       => '售楼电话',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $data = [];
            $data['id'] = array_get($this->data, 'id');
            $data['housing_price'] = array_get($this->data, 'housing_price');
            $data['has_sample_house'] = array_get($this->data, 'has_sample_house');
            $data['brand_id'] = array_get($this->data, 'brand_id');
            $data['opening_time'] = array_get($this->data, 'opening_time');
            $data['handing_time'] = array_get($this->data, 'handing_time');
            $data['sale_phone'] = array_get($this->data, 'sale_phone');

            $this->sale_data = $data;
        }

    }

}