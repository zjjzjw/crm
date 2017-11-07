<?php

namespace Huifang\Web\Src\Forms\Sale;

use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Src\Forms\Form;

class SaleDeleteForm extends Form
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
            'integer'     => ':attribute整型',
            'string'      => ':attribute字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id' => '主键',
        ];
    }

    public function validation()
    {
        $this->validateDeleteSale();
    }

    /**
     * 判断销售线索的删除数据权限
     */
    public function validateDeleteSale()
    {
        $id = array_get($this->data, 'id');
        $sale_repository = new SaleRepository();
        /** @var SaleEntity $sale_entity */
        $sale_entity = $sale_repository->fetch($id);
        if (isset($sale_entity) && $sale_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}