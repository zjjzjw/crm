<?php

namespace Huifang\Web\Src\Forms\Project\Aim;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\AimHinderStatus;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderSpecification;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Web\Src\Forms\Form;

class AimHinderSearchForm extends Form
{

    /**
     * @var ProjectAimHinderSpecification
     */
    public $aim_hinder_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'select_user_id' => 'integer',
            'keyword'        => 'string',
            'column'         => 'string',
            'sort'           => 'string',
            'page'           => 'integer',
            'status'         => 'integer',
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
            'select_user_id' => '选择用户ID',
            'keyword'        => '关键字',
            'column'         => '列名',
            'sort'           => '排序',
            'page'           => '当前页',
            'status'         => '审核状态',
        ];
    }


    public function validation()
    {
        $this->aim_hinder_specification = new ProjectAimHinderSpecification();
        $this->aim_hinder_specification->select_user_id = array_get($this->data, 'select_user_id');
        $this->aim_hinder_specification->keyword = array_get($this->data, 'keyword');
        $this->aim_hinder_specification->column = array_get($this->data, 'column', 'created_at');
        $this->aim_hinder_specification->sort = array_get($this->data, 'sort', 'desc');
        $this->aim_hinder_specification->user_ids = array_get($this->data, 'user_ids');
        $this->aim_hinder_specification->page = array_get($this->data, 'page');
        $this->aim_hinder_specification->status = array_get($this->data, 'status');
    }


}