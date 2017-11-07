<?php

namespace Huifang\Admin\Src\Forms\Sale\Brand;

use Huifang\Src\Sale\Brand\Domain\Model\BrandEntity;
use Huifang\Src\Sale\Brand\Infra\Repository\BrandRepository;
use Huifang\Web\Src\Forms\Form;

class BrandStoreForm extends Form
{

    /**
     * @var BrandEntity
     */
    public $brand_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'           => 'required|integer',
            'brand_name'   => 'required|string',
            'company_name' => 'required|string',
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
            'brand_name'   => '品牌名称',
            "company_name" => "公司名称",
        ];
    }

    public function validation()
    {

        if (array_get($this->data, 'id')) {
            $brand_repository = new BrandRepository();
            $this->brand_entity = $brand_repository->fetch(array_get($this->data, 'id'));
            $this->brand_entity->company_id = request()->user()->company_id;
        } else {
            $this->brand_entity = new BrandEntity();
            $this->brand_entity->company_id = request()->user()->company_id;
        }
        $this->brand_entity->brand_name = array_get($this->data, 'brand_name');
        $this->brand_entity->company_name = array_get($this->data, 'company_name');

    }

}