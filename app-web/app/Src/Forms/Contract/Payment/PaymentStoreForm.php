<?php

namespace Huifang\Web\Src\Forms\Contract\Payment;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentEntity;
use Huifang\Src\Contract\Domain\Model\ContractPaymentStatus;
use Huifang\Src\Contract\Domain\Model\ContractPaymentType;
use Huifang\Src\Contract\Infra\Repository\ContractPaymentRepository;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class  PaymentStoreForm extends Form
{

    /**
     * @var ContractPaymentEntity
     */
    public $contract_payment_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'             => 'required|integer',
            'contract_id'    => 'required|integer',
            'period'         => 'required|integer',
            'payment_amount' => 'required|numeric',
            'payment_type'   => 'required|integer',
            'payment_at'     => 'required|string|date_format:Y-m-d',
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
            'id'             => '主键',
            'contract_id'    => '合同ID',
            'period'         => '期数',
            'payment_amount' => '金额',
            'payment_type'   => '类型',
            'payment_at'     => '时间',
            'status'         => '状态',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $contract_payment_repository = new ContractPaymentRepository();
            $contract_payment_entity = $contract_payment_repository->fetch(array_get($this->data, 'id'));
        } else {
            $contract_payment_entity = new ContractPaymentEntity();
            $contract_payment_entity->status = ContractPaymentStatus::PROGRESS;
        }
        $contract_payment_entity->contract_id = array_get($this->data, 'contract_id');
        $contract_payment_entity->note = array_get($this->data, 'note');
        $contract_payment_entity->payment_amount = array_get($this->data, 'payment_amount');
        $contract_payment_entity->payment_at = Carbon::parse(array_get($this->data, 'payment_at'));
        $contract_payment_entity->period = array_get($this->data, 'period');
        $contract_payment_entity->payment_type = array_get($this->data, 'payment_type');

        $this->validateStorePayment($contract_payment_entity->contract_id, $contract_payment_entity->period, $contract_payment_entity->payment_type);
        $this->validatePaymentTotal($contract_payment_entity->contract_id, $contract_payment_entity->payment_type);

        $this->validateContractPaymentEdit();
        $this->contract_payment_entity = $contract_payment_entity;


    }


    public function validateStorePayment($contract_id, $period, $payment_type)
    {
        $contract_payment_repository = new ContractPaymentRepository();
        //计划回款
        if (!array_get($this->data, 'id') && $payment_type == ContractPaymentType::TYPE_PLAN) {
            $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, $period, ContractPaymentType::TYPE_PLAN);
            if (!$payment_entities->isEmpty()) {
                $this->addError('store_payment', '每一阶段只能添加一回款计划！');
            }
        } else if (!array_get($this->data, 'id') && $payment_type == ContractPaymentType::TYPE_RECORD) {
            $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, $period, ContractPaymentType::TYPE_PLAN);
            if ($payment_entities->isEmpty()) {
                $this->addError('store_payment', '请先添加回款计划！');
            }
        }
    }

    public function validatePaymentTotal($contract_id, $payment_type)
    {
        $contract_repository = new ContractRepository();
        /** @var ContractEntity $contract_entity */
        $contract_entity = $contract_repository->fetch($contract_id);

        $contract_payment_repository = new ContractPaymentRepository();

        if ($payment_type == ContractPaymentType::TYPE_PLAN) {
            if (!array_get($this->data, 'id')) {
                $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, null, ContractPaymentType::TYPE_PLAN);
                $plan_total_amount = $payment_entities->sum(function ($payment_item) {
                    return $payment_item->payment_amount;
                });
                $plan_total_amount += array_get($this->data, 'payment_amount');

                if ($plan_total_amount > $contract_entity->contract_amount) {
                    $this->addError('store_payment', '计划回款总额不能大于项目总额！');
                }
            } else {
                $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, null, ContractPaymentType::TYPE_PLAN);
                $plan_total_amount = $payment_entities->sum(function ($payment_item) {
                    if ($payment_item->id != array_get($this->data, 'id')) {
                        return $payment_item->payment_amount;
                    } else {
                        return 0;
                    }
                });
                $plan_total_amount += array_get($this->data, 'payment_amount');
                if ($plan_total_amount > $contract_entity->contract_amount) {
                    $this->addError('store_payment', '计划回款总额不能大于项目总额！');
                }
            }
        } elseif ($payment_type == ContractPaymentType::TYPE_RECORD) {
            if (!array_get($this->data, 'id')) {
                $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, null, ContractPaymentType::TYPE_RECORD);
                $record_total_amount = $payment_entities->sum(function ($payment_item) {
                    return $payment_item->payment_amount;
                });
                $record_total_amount += array_get($this->data, 'payment_amount');

                if ($record_total_amount > $contract_entity->contract_amount) {
                    $this->addError('store_payment', '实际回款总额不能大于项目总额！');
                }
            } else {
                $payment_entities = $contract_payment_repository->getPaymentByPeriodAndType($contract_id, null, ContractPaymentType::TYPE_RECORD);
                $record_total_amount = $payment_entities->sum(function ($payment_item) {
                    if ($payment_item->id != array_get($this->data, 'id')) {
                        return $payment_item->payment_amount;
                    } else {
                        return 0;
                    }
                });
                $record_total_amount += array_get($this->data, 'payment_amount');
                if ($record_total_amount > $contract_entity->contract_amount) {
                    $this->addError('store_payment', '实际回款总额不能大于项目总额！');
                }
            }
        }
    }

    /**
     * 验证合同回款的编辑权限
     */
    public function validateContractPaymentEdit()
    {
        $contract_id = array_get($this->data, 'contract_id');
        $contract_repository = new ContractRepository();
        /** @var ContractEntity $contract_entity */
        $contract_entity = $contract_repository->fetch($contract_id);
        if (isset($contract_entity) && $contract_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}