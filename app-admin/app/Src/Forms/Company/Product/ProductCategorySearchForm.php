<?php

namespace Huifang\Admin\Src\Forms\Company\Product;

use Huifang\Src\Product\Domain\Model\ProductCategorySpecification;
use Huifang\Admin\Src\Forms\Form;

class ProductCategorySearchForm extends Form
{

    /**
     * @var ProductCategorySpecification
     */
    public $product_category_specification;

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
        $this->product_category_specification = new ProductCategorySpecification();
        $this->product_category_specification->company_id = array_get($this->data, 'company_id');
        $this->product_category_specification->keyword = array_get($this->data, 'keyword');

    }


}