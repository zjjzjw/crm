<?php

namespace Huifang\Web\Src\Forms\Customer;

use Carbon\Carbon;
use Huifang\Src\Customer\Domain\Model\CustomerEntity;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Web\Src\Forms\Form;

class CustomerDeleteForm extends Form
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
        $this->validateCustomerDelete();
    }

    /**
     * 客户编辑权限
     */
    protected function validateCustomerDelete()
    {
        $id = array_get($this->data, 'id');
        $customer_repository = new CustomerRepository();
        /** @var CustomerEntity $customer_entity */
        $customer_entity = $customer_repository->fetch($id);
        if (isset($customer_entity) && $customer_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}