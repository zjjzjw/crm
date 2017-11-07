<?php

namespace Huifang\Crm\Src\Forms\Company\Product;

use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Crm\Src\Forms\Form;

class ProductSearchForm extends Form
{

    /**
     * @var ProductSpecification
     */
    public $product_specification;

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
        $this->product_specification = new ProductSpecification();
        $this->product_specification->company_id = array_get($this->data, 'company_id');
        $this->product_specification->keyword = array_get($this->data, 'keyword');
    }


}