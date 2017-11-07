<?php

namespace Huifang\Admin\Src\Forms\Company\Rival;

use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Product\Domain\Model\AscriptionType;
use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Product\Infra\Repository\RivalRepository;

class RivalDeleteForm extends Form
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
        //竞品公司ID
        $company_id = array_get($this->data, 'id');
        $this->validateRival($company_id);
    }


    public function validateRival($company_id)
    {
        $product_repository = new ProductRepository();
        $spec = new ProductSpecification();
        $spec->company_id = $company_id;
        $spec->ascription = AscriptionType::TYPE_RIVAL;
        $product_entities = $product_repository->getProductsBySpecification($spec);

        if (!$product_entities->isEmpty()) {
            $this->addError('delete', '该竞品公司已被使用，请先删除相关依赖！');
        }
    }


}