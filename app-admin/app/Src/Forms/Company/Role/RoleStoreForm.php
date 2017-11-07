<?php

namespace Huifang\Admin\Src\Forms\Company\Role;

use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Domain\Model\RoleEntity;
use Huifang\Src\Role\Infra\Repository\RoleRepository;
use Huifang\Admin\Src\Forms\Form;

class RoleStoreForm extends Form
{

    /**
     * @var RoleEntity
     */
    public $role_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'name'        => 'required|string',
            'permissions' => 'required|array',
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
            'name'        => '角色名称',
            'permissions' => '权限',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $role_repository = new RoleRepository();
            $this->role_entity = $role_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->role_entity = new RoleEntity();
            $this->role_entity->company_id = request()->user()->company->id;
        }
        $this->role_entity->name = array_get($this->data, 'name');
        $this->role_entity->permissions = array_get($this->data, 'permissions');
        $this->role_entity->desc = '';
    }

}