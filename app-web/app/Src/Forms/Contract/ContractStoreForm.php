<?php

namespace Huifang\Web\Src\Forms\Contract;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractEntity;
use Huifang\Src\Contract\Infra\Repository\ContractRepository;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class ContractStoreForm extends Form
{

    /**
     * @var ContractEntity
     */
    public $contract_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                  => 'required|integer',
            'contract_number'     => 'required|string',
            'contract_name'       => 'required|string',
            'signed_at'           => 'required|string|date_format:Y-m-d',
            'customer_name'       => 'required|string',
            'contract_amount'     => 'required|numeric',
            'down_payment'        => 'required|numeric',
            'expected_return_at'  => 'required|string|date_format:Y-m-d',
            'tail_amount'         => 'required|numeric',
            'tail_amount_at'      => 'required|string|date_format:Y-m-d',
            'product_delivery_at' => 'required|string|date_format:Y-m-d',
            'products'            => 'required|array',
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
            'id'                  => '主键',
            'user_id'             => '用户ID',
            'company_id'          => '公司ID',
            'contract_number'     => '合同编号',
            'contract_name'       => '合同名称',
            'signed_at'           => '合同签订日期',
            'customer_name'       => '客户名称',
            'products'            => '产品必选',
            'contract_amount'     => '合同金额',
            'down_payment'        => '首付款',
            'expected_return_at'  => '预计回款日期',
            'tail_amount'         => '尾款金额',
            'tail_amount_at'      => '尾款日期',
            'product_delivery_at' => '产品交付日期',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $id = array_get($this->data, 'id');
            $contract_repository = new ContractRepository();
            $contract_entity = $contract_repository->fetch($id);
        } else {
            $contract_entity = new ContractEntity();
            //得到创建者
            $contract_entity->created_user_id = request()->user()->id;
            $contract_entity->user_id = request()->user()->id;
            $contract_entity->company_id = request()->user()->company_id;

            //遗留字段默认值
            $contract_entity->customer_id = 0;
            $contract_entity->product_id = 0;
            $contract_entity->product_number = 0;
            $contract_entity->product_price = 0;
        }

        $contract_entity->contract_number = array_get($this->data, 'contract_number');
        $contract_entity->contract_name = array_get($this->data, 'contract_name');

        $contract_entity->customer_name = array_get($this->data, 'customer_name');
        $contract_entity->contract_amount = array_get($this->data, 'contract_amount');
        $contract_entity->down_payment = array_get($this->data, 'down_payment');
        $contract_entity->expected_return_at = Carbon::parse(array_get($this->data, 'expected_return_at'));
        $contract_entity->tail_amount = array_get($this->data, 'tail_amount');
        $contract_entity->tail_amount_at = array_get($this->data, 'tail_amount_at');
        $contract_entity->product_delivery_at = array_get($this->data, 'product_delivery_at');
        $contract_entity->signed_at = Carbon::parse(array_get($this->data, 'signed_at'));

        $contract_entity->products = $this->formatDataFromHorToVert(array_get($this->data, 'products'));
        $this->validateContractEdit();
        $this->contract_entity = $contract_entity;

    }

    /**
     * 验证合同管理数据权限
     */
    public function validateContractEdit()
    {
        if (array_get($this->data, 'id')) {
            $contract_repository = new ContractRepository();
            /** @var ContractEntity $contract_entity */
            $contract_entity = $contract_repository->fetch(array_get($this->data, 'id'));
            if (isset($contract_entity) && $contract_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足！');
            }
        }
    }


}