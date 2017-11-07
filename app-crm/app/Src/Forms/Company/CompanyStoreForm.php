<?php

namespace Huifang\Crm\Src\Forms\Company;

use Carbon\Carbon;
use Huifang\Src\Company\Domain\Model\CompanyEntity;
use Huifang\Src\Company\Infra\Repository\CompanyRepository;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Crm\Src\Forms\Form;

class CompanyStoreForm extends Form
{

    /**
     * @var CompanyEntity
     */
    public $company_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'name'        => 'required|string',
            'start_time'  => 'required|date_format:Y-m-d',
            'end_time'    => 'required|date_format:Y-m-d',
            'is_free'     => 'required|integer',
            'user_number' => 'required|integer',
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
            'project_name' => '公司名称',
            'start_time'   => '生效时间',
            'end_time'     => '结束时间',
            'is_free'      => '是否免费',
            'user_number'  => '账号数量',
        ];
    }


    public function validation()
    {

        $this->company_entity = new CompanyEntity();
        if (!empty(array_get($this->data, 'id'))) {
            $company_repository = new CompanyRepository();
            $this->company_entity = $company_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->company_entity = new CompanyEntity();
        }
        $this->company_entity->start_time = Carbon::parse(array_get($this->data, 'start_time'));
        $this->company_entity->end_time = Carbon::parse(array_get($this->data, 'end_time'));
        $this->company_entity->name = array_get($this->data, 'name');
        $this->company_entity->is_free = array_get($this->data, 'is_free');
        $this->company_entity->user_number = array_get($this->data, 'user_number');
        $this->company_entity->created_user_id = 1;
    }


}