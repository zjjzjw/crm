<?php

namespace Huifang\Web\Src\Forms\Contract\Payment;

use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentType;
use Huifang\Src\Contract\Infra\Repository\ContractPaymentRepository;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Web\Src\Forms\Form;

class  PaymentDeleteForm extends Form
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
        $contract_payment_repository = new ContractPaymentRepository();
        /** @var ContractPaymentEntity $contract_payment_entity */
        $contract_payment_entity = $contract_payment_repository->fetch(array_get($this->data, 'id'));
        if (isset($contract_payment_entity)) {
            $this->validateDeletePayment($contract_payment_entity->contract_id, $contract_payment_entity->period, $contract_payment_entity->payment_type);
        }
    }

    public function validateDeletePayment($contract_id, $period, $payment_type)
    {
        //判断数据权限
        $contract_repository = new ContractRepository();
        /** @var ContractEntity $contract_entity */
        $contract_entity = $contract_repository->fetch($contract_id);
        if (isset($contract_entity) && $contract_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }

        //如果删除的是计划,需要判断是否有回款记录
        if ($payment_type == ContractPaymentType::TYPE_PLAN) {
            $contract_payment_repository = new ContractPaymentRepository();
            $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, $period, ContractPaymentType::TYPE_RECORD);
            if (!$payment_entities->isEmpty()) {
                $this->addError('delete_payment', '请先删除回款记录！');
            }
        }

    }

}