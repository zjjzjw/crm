<?php

namespace Huifang\Web\Src\Forms\Contract;

use Carbon\Carbon;
use Huifang\Src\Contract\Domain\Model\ContractSpecification;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Web\Src\Forms\Form;

class ContractSearchForm extends Form
{

    /**
     * @var ContractSpecification
     */
    public $contract_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id'     => 'integer',
            'user_id'        => 'integer',
            'keyword'        => 'string',
            'select_user_id' => 'integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute是整型',
        ];
    }

    public function attributes()
    {
        return [
            'company_id'     => '公司ID',
            'user_id'        => '用户ID',
            'keyword'        => '关键词',
            'select_user_id' => '选择用户',
        ];
    }


    public function validation()
    {
        $this->contract_specification = new ContractSpecification();

        if (array_get($this->data, 'company_id')) {
            $this->contract_specification->company_id = array_get($this->data, 'company_id');
        }

        if (array_get($this->data, 'user_id')) {
            $this->contract_specification->user_id = array_get($this->data, 'user_id');
        }

        if (array_get($this->data, 'keyword')) {
            $this->contract_specification->keyword = array_get($this->data, 'keyword');
        }

        if (array_get($this->data, 'select_user_id')) {
            $this->contract_specification->select_user_id = array_get($this->data, 'select_user_id');
        }

        //管理的数据权限
        if (!empty(array_get($this->data, 'user_ids'))) {
            $this->contract_specification->user_ids = array_get($this->data, 'user_ids');
        }

    }


}