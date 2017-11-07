<?php

namespace Huifang\Admin\Src\Forms\Company\User;

use Huifang\Src\Role\Domain\Model\RoleSpecification;
use Huifang\Src\Role\Domain\Model\UserSpecification;
use Huifang\Admin\Src\Forms\Form;

class UserSearchForm extends Form
{

    /**
     * @var UserSpecification
     */
    public $user_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'integer',
            'keyword'    => 'string',
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
            'company_id' => '公司ID',
            'keyword'    => '关键字',
        ];
    }


    public function validation()
    {
        $this->user_specification = new UserSpecification();
        $this->user_specification->company_id = array_get($this->data, 'company_id');
        $this->user_specification->keyword = array_get($this->data, 'keyword');
    }

}