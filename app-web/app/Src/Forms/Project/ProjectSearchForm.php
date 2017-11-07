<?php

namespace Huifang\Web\Src\Forms\Project;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Web\Src\Forms\Form;

class ProjectSearchForm extends Form
{

    /**
     * @var ProjectSpecification
     */
    public $project_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id'          => 'integer',
            'province_id'         => 'integer',
            'city_id'             => 'integer',
            'project_volume_type' => 'integer',
            'user_id'             => 'integer',
            'keyword'             => 'string',
            'start_time'          => 'string|date_format:Y-m-d',
            'end_time'            => 'string|date_format:Y-m-d',
            'select_user_id'      => 'integer',
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
            'company_id'          => '公司ID',
            'province_id'         => '省份',
            'city_id'             => '城市',
            'project_volume_type' => '工程体量',
            'user_id'             => '用户ID',
            'keyword'             => '关键词',
            'start_time'          => '开始时间',
            'end_time'            => '结束时间',
        ];
    }


    public function validation()
    {
        $this->project_specification = new ProjectSpecification();

        if (array_get($this->data, 'company_id')) {
            $this->project_specification->company_id = array_get($this->data, 'company_id');
        }

        if (array_get($this->data, 'province_id')) {
            $this->project_specification->province_id = array_get($this->data, 'province_id');
        }
        if (array_get($this->data, 'city_id')) {
            $this->project_specification->city_id = array_get($this->data, 'city_id');
        }

        if (array_get($this->data, 'project_volume_type')) {
            $this->project_specification->project_volume_type = array_get($this->data, 'project_volume_type');
            $project_volume_limits = ProjectVolumeType::acceptableLimits();
            if (isset($project_volume_limits[$this->project_specification->project_volume_type])) {
                $this->project_specification->project_volume_min =
                    $project_volume_limits[$this->project_specification->project_volume_type][0];
                $this->project_specification->project_volume_max =
                    $project_volume_limits[$this->project_specification->project_volume_type][1];
            }
        }


        if (array_get($this->data, 'start_time')) {
            $this->project_specification->start_time = Carbon::parse(array_get($this->data, 'start_time'));
        }

        if (array_get($this->data, 'end_time')) {
            $this->project_specification->end_time = Carbon::parse(array_get($this->data, 'end_time'));
        }

        if (array_get($this->data, 'user_id')) {
            $this->project_specification->user_id = array_get($this->data, 'user_id');
        }

        if (array_get($this->data, 'keyword')) {
            $this->project_specification->keyword = array_get($this->data, 'keyword');
        }

        if (array_get($this->data, 'select_user_id')) {
            $this->project_specification->select_user_id = array_get($this->data, 'select_user_id');
        }

        //管理的数据权限
        if (!empty(array_get($this->data, 'user_ids'))) {
            $this->project_specification->user_ids = array_get($this->data, 'user_ids');
        }

        $project_ids = array_get($this->data, 'project_ids');
        if (isset($project_ids)) {
            $this->project_specification->project_ids = $project_ids;
        }


    }


}