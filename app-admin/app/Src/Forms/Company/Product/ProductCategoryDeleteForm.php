<?php

namespace Huifang\Admin\Src\Forms\Company\Product;

use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Src\Product\Infra\Repository\ProductCategoryRepository;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Web\Src\Forms\Form;

class ProductCategoryDeleteForm extends Form
{
    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
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
            'id' => '主键ID',
        ];
    }


    public function validation()
    {
        $category_id = array_get($this->data, 'id');
        $this->validateCategory($category_id);
    }

    public function validateCategory($category_id)
    {
        $product_repository = new ProductRepository();

        $spec = new ProductSpecification();
        $spec->category_id = $category_id;
        $product_entities = $product_repository->getProductsBySpecification($spec);

        if (!$product_entities->isEmpty()) {
            $this->addError('delete', '该产品分类已被使用，请先删除相关依赖！');
        }
    }


}