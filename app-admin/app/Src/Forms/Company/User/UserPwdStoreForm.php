<?php

namespace Huifang\Admin\Src\Forms\Company\User;

use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Admin\Src\Forms\Form;

class UserPwdStoreForm extends Form
{

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'               => 'required|integer',
            'password'         => 'required|string',
            'confirm_password' => 'required|string',
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
            'id'               => '用户ID',
            'password'         => '密码',
            'confirm_password' => '确认密码',
        ];
    }


    public function validation()
    {
        $this->id = array_get($this->data, 'id');
        $this->password = array_get($this->data, 'password');
        $this->confirm_password = array_get($this->data, 'confirm_password');
        if ($this->password != $this->confirm_password) {
            $this->addError('confirm', '两次密码不一致! ');
        }
    }

}