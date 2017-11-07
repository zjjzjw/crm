<?php

namespace Huifang\Web\Src\Forms\Contract;

use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Web\Src\Forms\Form;

class ContractDeleteForm extends Form
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
            'integer'     => ':attribute是整型',
            'string'      => ':attribute是字符串',
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
        $this->validateContractDelete();
    }

    /**
     * 验证合同管理数据权限
     */
    protected function validateContractDelete()
    {
        $id = array_get($this->data, 'id');
        $contract_repository = new ContractRepository();
        /** @var ContractEntity $contract_entity */
        $contract_entity = $contract_repository->fetch($id);
        if (isset($contract_entity) && $contract_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}