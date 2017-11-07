<?php

namespace Huifang\Crm\Src\Forms\Company;

use Carbon\Carbon;
use Huifang\Crm\Src\Forms\Form;
use Huifang\Service\Card\CardService;
use Huifang\Src\Company\Domain\Model\CompanySpecification;

class CompanySearchForm extends Form
{

    /**
     * @var CompanySpecification
     */
    public $company_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_time' => 'date_format:Y-m-d',
            'end_time'   => 'date_format:Y-m-d',
            'keyword'    => 'string',
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
            'start_time' => '生效时间',
            'end_time'   => '结束时间',
            'keyword'    => '关键字',
        ];
    }


    public function validation()
    {
        $this->company_specification = new CompanySpecification();
        if (array_get($this->data, 'start_time')) {
            $this->company_specification->start_time = Carbon::parse(array_get($this->data, 'start_time'));
        }
        if (array_get($this->data, 'end_time')) {
            $this->company_specification->end_time = Carbon::parse(array_get($this->data, 'end_time'));
        }
        $this->company_specification->keyword = array_get($this->data, 'keyword');
    }

}