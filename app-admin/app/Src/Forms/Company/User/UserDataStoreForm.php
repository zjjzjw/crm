<?php

namespace Huifang\Admin\Src\Forms\Company\User;

use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Admin\Src\Forms\Form;

class UserDataStoreForm extends Form
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
            'id'         => '用户ID',
            'depart_ids' => '部门',
        ];
    }


    public function validation()
    {
        $this->depart_ids = array_get($this->data, 'depart_ids', []);
        $this->id = array_get($this->data, 'id');
    }

}