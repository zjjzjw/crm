<?php

namespace Huifang\Admin\Src\Forms\Sale\Developer;

use Huifang\Src\Sale\Developer\Domain\Model\DeveloperSpecification;
use Huifang\Admin\Src\Forms\Form;

class DeveloperSearchForm extends Form
{

    /**
     * @var DeveloperSpecification
     */
    public $developer_specification;

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
        $this->developer_specification = new DeveloperSpecification();
        $this->developer_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_specification->company_id = array_get($this->data, 'company_id');
    }


}