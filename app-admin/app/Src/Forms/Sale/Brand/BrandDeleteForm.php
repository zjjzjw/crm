<?php

namespace Huifang\Admin\Src\Forms\Sale\Brand;

use Huifang\Src\Sale\Brand\Domain\Model\BrandSpecification;
use Huifang\Src\Sale\Brand\Infra\Repository\BrandRepository;
use Huifang\Web\Src\Forms\Form;

class BrandDeleteForm extends Form
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
        $id = array_get($this->data, 'id');

        $this->validateCategory($id);

    }

    public function validateCategory($id)
    {
        $brand_repository = new BrandRepository();

        $spec = new BrandSpecification();

        $spec->id = $id;

        $brand_entities = $brand_repository->getBrandsBySpecification($spec);


    }


}