<?php

namespace Huifang\Admin\Src\Forms\Sale\LargeArea;

use Huifang\Src\Sale\LargeArea\Domain\Model\LargeAreaSpecification;
use Huifang\Admin\Src\Forms\Form;

class LargeAreaSearchForm extends Form
{

    /**
     * @var LargeAreaSpecification
     */
    public $largeArea_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'keyword'    => 'string',
            'company_id' => 'integer',
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

            'keyword'    => '关键字',
        ];
    }

    public function validation()
    {
        $this->largeArea_specification = new LargeAreaSpecification();
        $this->largeArea_specification->keyword = array_get($this->data, 'keyword');
        $this->largeArea_specification->company_id = array_get($this->data, 'company_id');
    }


}