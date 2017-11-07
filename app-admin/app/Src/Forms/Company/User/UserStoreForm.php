<?php

namespace Huifang\Admin\Src\Forms\Company\User;

use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Admin\Src\Forms\Form;

class UserStoreForm extends Form
{

    /**
     * @var UserEntity
     */
    public $user_entity;

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
            'email'       => 'required|string',
            'phone'       => 'required|string|max:11',
            'role_ids'    => 'required|array',
            'depart_ids'  => 'required|array',
            'user_images' => 'integer',
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
            'name'        => '名称',
            'email'       => '邮箱',
            'phone'       => '手机号码',
            'role_ids'    => '角色权限',
            'depart_ids'  => '部门',
            'user_images' => '用户头像',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $role_repository = new UserRepository();
            $this->user_entity = $role_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->user_entity = new UserEntity();
            $this->user_entity->company_id = request()->user()->company->id;
            $this->user_entity->created_user_id = request()->user()->id;
        }
        $this->user_entity->name = array_get($this->data, 'name');
        $this->user_entity->email = array_get($this->data, 'email');
        $this->user_entity->phone = array_get($this->data, 'phone');
        $this->user_entity->start_time = array_get($this->data, 'start_time');
        $this->user_entity->end_time = array_get($this->data, 'end_time');

        $this->user_entity->role_ids = array_get($this->data, 'role_ids');
        $this->user_entity->depart_ids = array_get($this->data, 'depart_ids');
        $this->user_entity->image_id = array_get($this->data, 'user_images', 0);

        $this->validatePhone();
    }


    public function validatePhone()
    {
        $phone = array_get($this->data, 'phone');
        $user_repository = new UserRepository();
        /** @var UserEntity $user_entity */
        $user_entities = $user_repository->getUserByPhone($phone);
        if (!array_get($this->data, 'id')) {
            if (!$user_entities->isEmpty()) {
                $this->addError('phone_has_use', $this->user_entity->phone . '号码已注册！');
            }
        } else if (array_get($this->data, 'id')) {
            foreach ($user_entities as $user_entity) {
                if ($user_entity->id != array_get($this->data, 'id')) {
                    $this->addError('phone_has_use', $this->user_entity->phone . '号码已注册！');
                }
            }
        }
    }

}