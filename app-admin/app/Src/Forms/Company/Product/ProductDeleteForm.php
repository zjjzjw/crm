<?php

namespace Huifang\Admin\Src\Forms\Company\Product;

use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Product\Domain\Model\AscriptionType;
use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;

class ProductDeleteForm extends Form
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
        $product_id = array_get($this->data, 'id');
        $this->validateProduct($product_id);
    }

    public function validateProduct($product_id)
    {
        $project_aim_repository = new ProjectAimRepository();
        $project_aim_entities = $project_aim_repository->getProjectAimsByProductId($product_id);
        if (!$project_aim_entities->isEmpty()) {
            $this->addError('delete', '该产品已被使用，请先删除相关依赖！');
        }
    }

}