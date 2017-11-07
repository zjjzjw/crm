<?php

namespace Huifang\Admin\Src\Forms\Company\Depart;

use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Role\Domain\Model\DepartSpecification;
use Huifang\Admin\Src\Forms\Form;

class DepartSearchForm extends Form
{

    /**
     * @var DepartSpecification
     */
    public $depart_specification;

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
            'parent_id'  => 'integer',
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
            'parent_id'  => '父id',
        ];
    }


    public function validation()
    {
        $this->depart_specification = new DepartSpecification();
        $this->depart_specification->company_id = array_get($this->data, 'company_id');
        $this->depart_specification->keyword = array_get($this->data, 'keyword');
        $this->depart_specification->parent_id = array_get($this->data, 'parent_id');

    }


}