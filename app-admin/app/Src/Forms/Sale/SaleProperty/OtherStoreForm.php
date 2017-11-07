<?php

namespace Huifang\Admin\Src\Forms\Sale\SaleProperty;

use Huifang\Web\Src\Forms\Form;

class OtherStoreForm extends Form
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
            'id'    => 'required|integer',
            'remake' => 'string',
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
            'remake' => '备注',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $data = [];
            $data['id'] = array_get($this->data, 'id');
            $data['remake'] = array_get($this->data, 'remake');

            $this->sale_data = $data;
        }

    }

}