<?php

namespace Huifang\Admin\Src\Forms\Company\Product;

use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Web\Src\Forms\Form;

class ProductStoreForm extends Form
{

    /**
     * @var UserEntity
     */
    public $product_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'             => 'required|integer',
            'company_id'     => 'required|integer',
            'name'           => 'required|string',
            'ascription'     => 'required|integer',
            'ascription_id'  => 'required|integer',
            'price'          => 'required|numeric',
            'product_images' => 'required|array',
            'category_id'    => 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'max'         => ':attribute最大长度',
            'numeric'     => ':attribute为数字',
        ];
    }

    public function attributes()
    {
        return [
            'company_id'       => '公司ID',
            'name'             => '产品名称',
            'ascription'       => '产品归属',
            'price'            => '产品价格',
            'product_images'   => '产品图片',
            'product_category' => '产品分类',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $role_repository = new ProductRepository();
            $this->product_entity = $role_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->product_entity = new ProductEntity();
            $this->product_entity->company_id = request()->user()->company->id;
        }
        $this->product_entity->ascription = array_get($this->data, 'ascription');
        $this->product_entity->ascription_id = array_get($this->data, 'ascription_id');
        $this->product_entity->price = array_get($this->data, 'price');
        $this->product_entity->name = array_get($this->data, 'name');
        $this->product_entity->product_images = (array)array_get($this->data, 'product_images');
        $this->product_entity->category_id = array_get($this->data, 'category_id');
        if (!empty(array_get($this->data, 'parameter'))) {
            $this->product_entity->attribfield = \GuzzleHttp\json_encode($this->formatDataFromHorToVert(array_get($this->data, 'parameter')));
        } else {
            $this->product_entity->attribfield = \GuzzleHttp\json_encode([]);
        }
    }

}