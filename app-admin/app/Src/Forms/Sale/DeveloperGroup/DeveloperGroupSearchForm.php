<?php

namespace Huifang\Admin\Src\Forms\Sale\DeveloperGroup;

use Huifang\Src\Sale\DeveloperGroup\Domain\Model\DeveloperGroupSpecification;
use Huifang\Admin\Src\Forms\Form;

class DeveloperGroupSearchForm extends Form
{

    /**
     * @var DeveloperGroupSpecification
     */
    public $developer_group_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'    => 'string',
            'company_id' => 'integer',
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

            'keyword' => '关键字',
        ];
    }

    public function validation()
    {
        $this->developer_group_specification = new DeveloperGroupSpecification();
        $this->developer_group_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_group_specification->company_id = array_get($this->data, 'company_id');
    }


}