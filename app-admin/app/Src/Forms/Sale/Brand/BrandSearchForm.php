<?php

namespace Huifang\Admin\Src\Forms\Sale\Brand;

use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;
use Huifang\Admin\Src\Forms\Form;

class BrandSearchForm extends Form
{

    /**
     * @var BrandSpecification
     */
    public $brand_specification;

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
        $this->brand_specification = new BrandSpecification();
        $this->brand_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_specification->company_id = array_get($this->data, 'company_id');

    }


}