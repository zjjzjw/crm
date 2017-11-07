<?php

namespace Huifang\Admin\Src\Forms\Company\Depart;

use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Role\Infra\Repository\UserDepartRepository;

class DepartDeleteForm extends Form
{

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
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
        $depart_id = array_get($this->data, 'id');
        $this->validateDepart($depart_id);
    }


    public function validateDepart($depart_id)
    {
        $user_depart_repository = new UserDepartRepository();
        $depart_repository = new DepartRepository();
        $user_depart_entities = $user_depart_repository->getUserDepartByDepartId($depart_id);
        $depart_entities = $depart_repository->getDepartByParentId($depart_id);
        if (!$user_depart_entities->isEmpty() || !$depart_entities->isEmpty()) {
            $this->addError('delete', '该部门已被使用，请先删除相关依赖！');
        }
    }

}