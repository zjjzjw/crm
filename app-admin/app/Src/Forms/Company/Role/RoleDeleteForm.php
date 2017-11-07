<?php

namespace Huifang\Admin\Src\Forms\Company\Role;

use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Domain\Model\RoleEntity;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Role\Infra\Repository\UserRoleRepository;

class RoleDeleteForm extends Form
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
        $role_id = array_get($this->data, 'id');
        $this->validateRole($role_id);
    }


    public function validateRole($role_id)
    {
        $user_role_repository = new UserRoleRepository();
        $user_role_entities = $user_role_repository->getUserRoleByRoleId($role_id);
        if (!$user_role_entities->isEmpty()) {
            $this->addError('delete', '该角色已被使用，请先删除相关依赖！');
        }
    }

}