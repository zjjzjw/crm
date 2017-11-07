<?php

namespace Huifang\Web\Src\Forms\Customer;

use Carbon\Carbon;
use Huifang\Src\Customer\Domain\Model\CustomerEntity;
use Huifang\Src\Customer\Infra\Repository\CustomerRepository;
use Huifang\Web\Src\Forms\Form;

class CustomerStoreForm extends Form
{

    /**
     * @var CustomerEntity
     */
    public $customer_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    => 'required|integer',
            'customer_company_name' => 'required|string',
            'province_id'           => 'required|integer',
            'city_id'               => 'required|integer',
            'contact_name'          => 'required|string',
            'position_name'         => 'required|string',
            'contact_phone'         => 'required|string',
            'project_count'         => 'required|integer',
            'build_project_count'   => 'required|integer',
            'future_potential'      => 'required|integer',
            'record'                => 'required|string',
            'use_brand'             => 'required|string',
            'level'                 => 'required|integer',
            'per_signed_at'         => 'required|string|date_format:Y-m-d',
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
            'id'                    => '主键',
            'customer_company_name' => '客户所在公司名称',
            'province_id'           => '省ID',
            'city_id'               => '市ID',
            'contact_name'          => '联系人姓名',
            'position_name'         => '职位',
            'contact_phone'         => '联系人电话',
            'project_count'         => '项目数量',
            'build_project_count'   => '在建项目数量',
            'future_potential'      => '未来潜量',
            'record'                => '开发记录',
            'use_brand'             => '使用品牌',
            'volume'                => '体量',
            'level'                 => '客户等级',
            'per_signed_at'         => '预计签约日期',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $id = array_get($this->data, 'id');
            $customer_repository = new CustomerRepository();
            $customer_entity = $customer_repository->fetch($id);
        } else {
            $customer_entity = new CustomerEntity();
            //得到创建者
            $customer_entity->created_user_id = request()->user()->id;
            $customer_entity->user_id = request()->user()->id;
            $customer_entity->company_id = request()->user()->company_id;
            $customer_entity->volume = 0;

        }
        $customer_entity->customer_company_name = array_get($this->data, 'customer_company_name');
        $customer_entity->province_id = array_get($this->data, 'province_id');
        $customer_entity->city_id = array_get($this->data, 'city_id');
        $customer_entity->contact_name = array_get($this->data, 'contact_name');
        $customer_entity->position_name = array_get($this->data, 'position_name');
        $customer_entity->contact_phone = array_get($this->data, 'contact_phone');
        $customer_entity->project_count = array_get($this->data, 'project_count');
        $customer_entity->build_project_count = array_get($this->data, 'build_project_count');
        $customer_entity->record = array_get($this->data, 'record');
        $customer_entity->future_potential = array_get($this->data, 'future_potential');
        $customer_entity->use_brand = array_get($this->data, 'use_brand');
        $customer_entity->level = array_get($this->data, 'level');
        $customer_entity->per_signed_at = Carbon::parse(array_get($this->data, 'per_signed_at'));

        $this->validateCustomerEdit();
        $this->customer_entity = $customer_entity;
    }

    /**
     * 客户编辑权限
     */
    public function validateCustomerEdit()
    {
        if (array_get($this->data, 'id')) {
            $customer_repository = new CustomerRepository();
            /** @var CustomerEntity $customer_entity */
            $customer_entity = $customer_repository->fetch(array_get($this->data, 'id'));
            if (isset($customer_entity) && $customer_entity->user_id != request()->user()->id) {
                $this->addError('permission', '权限不足！');
            }
        }
    }

}