<?php

namespace Huifang\Crm\Src\Forms\Company\Role;

use Huifang\Src\Role\Domain\Model\RoleSpecification;
use Huifang\Crm\Src\Forms\Form;

class RoleSearchForm extends Form
{

    /**
     * @var RoleSpecification
     */
    public $role_specification;

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
        $this->role_specification = new RoleSpecification();
        $this->role_specification->company_id = array_get($this->data, 'company_id');
        $this->role_specification->keyword = array_get($this->data, 'keyword');
    }

}