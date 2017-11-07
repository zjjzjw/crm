<?php

namespace Huifang\Admin\Src\Forms\Sale;

use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Admin\Src\Forms\Form;

class SaleSearchForm extends Form
{

    /**
     * @var SaleSpecification
     */
    public $sale_specification;

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

            'keyword'    => '关键字',
        ];
    }

    public function validation()
    {
        $this->sale_specification = new SaleSpecification();
        $this->sale_specification->keyword = array_get($this->data, 'keyword');
        $this->sale_specification->company_id = array_get($this->data, 'company_id');
    }


}