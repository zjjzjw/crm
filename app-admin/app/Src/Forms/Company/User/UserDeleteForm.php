<?php

namespace Huifang\Admin\Src\Forms\Company\User;

use Huifang\Admin\Src\Forms\Form;

class UserDeleteForm extends Form
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
            'integer'     => ':attribute必须是数字',
            'max'         => ':attribute最大长度',
        ];
    }

    public function attributes()
    {
        return [
            'id' => '主键ID',
        ];
    }


    public function validation()
    {
        $this->id = array_get($this->data, 'id');
    }

}