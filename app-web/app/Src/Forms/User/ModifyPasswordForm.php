<?php

namespace Huifang\Web\Src\Forms\User;

use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Web\Src\Forms\Form;

class ModifyPasswordForm extends Form
{

    /**
     * @var string
     */
    public $old_password;

    /**
     * @var string
     */
    public $new_password;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'new_password' => 'required|string',
        ];
    }


    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute整型',
            'string'      => ':attribute字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id'           => '主键',
            'old_password' => '原始密码',
            'new_password' => '新密码',
        ];
    }

    public function validation()
    {
        $this->old_password = array_get($this->data, 'old_password');
        $this->new_password = array_get($this->data, 'new_password');
        $this->validateOldPassword();

    }

    public function validateOldPassword()
    {
        $old_password = array_get($this->data, 'old_password');
        $old_password = md5(md5($old_password) . config('auth.salt'));
        $user_id = request()->user()->id;
        $user_repository = new UserRepository();
        /** @var UserEntity $user_entity */
        $user_entity = $user_repository->fetch($user_id);
        if ($user_entity->password != $old_password) {
            $this->addError('old_password', '错误！');
        }
    }

}