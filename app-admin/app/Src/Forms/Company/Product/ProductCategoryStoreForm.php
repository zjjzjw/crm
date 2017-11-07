<?php

namespace Huifang\Admin\Src\Forms\Company\Product;

use Huifang\Src\Product\Domain\Model\ProductCategoryEntity;
use Huifang\Src\Product\Infra\Repository\ProductCategoryRepository;
use Huifang\Web\Src\Forms\Form;

class ProductCategoryStoreForm extends Form
{

    /**
     * @var ProductCategoryEntity
     */
    public $product_category_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'   => 'required|integer',
            'name' => 'required|string',
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
            'name' => '产品名称',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $product_category_repository = new ProductCategoryRepository();
            $this->product_category_entity = $product_category_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->product_category_entity = new ProductCategoryEntity();
            $this->product_category_entity->company_id = request()->user()->company->id;
        }
        $this->product_category_entity->name = array_get($this->data, 'name');
    }

}