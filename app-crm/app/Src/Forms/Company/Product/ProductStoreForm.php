<?php

namespace Huifang\Crm\Src\Forms\Company\Product;

use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Crm\Src\Forms\Form;

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
            'id'         => 'required|integer',
            'company_id' => 'required|integer',
            'name'       => 'required|string',
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
            'company_id' => '公司ID',
            'name'       => '产品名称',
        ];
    }


    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $role_repository = new ProductRepository();
            $this->product_entity = $role_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->product_entity = new ProductEntity();
        }
        $this->product_entity->company_id = array_get($this->data, 'company_id');
        $this->product_entity->name = array_get($this->data, 'name');
    }

}