<?php

namespace Huifang\Admin\Src\Forms\Company\Rival;

use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Product\Domain\Model\RivalSpecification;

class RivalSearchForm extends Form
{

    /**
     * @var RivalSpecification
     */
    public $rival_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'integer',
            'keyword'    => 'string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'company_id' => '公司ID',
            'keyword'    => '关键字',
        ];
    }


    public function validation()
    {
        $this->rival_specification = new RivalSpecification();
        $this->rival_specification->company_id = array_get($this->data, 'company_id');
        $this->rival_specification->keyword = array_get($this->data, 'keyword');
    }


}