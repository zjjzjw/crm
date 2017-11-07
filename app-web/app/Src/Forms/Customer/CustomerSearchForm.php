<?php

namespace Huifang\Web\Src\Forms\Customer;

use Carbon\Carbon;
use Huifang\Src\Customer\Domain\Model\BuildProjectCountType;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Customer\Domain\Model\FuturePotentialType;
use Huifang\Src\Customer\Domain\Model\ProjectCountType;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Web\Src\Forms\Form;
use PhpParser\Node\Name\FullyQualified;

class  CustomerSearchForm extends Form
{

    /**
     * @var CustomerSpecification
     */
    public $customer_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id'               => 'integer',
            'province_id'              => 'integer',
            'city_id'                  => 'integer',
            'user_id'                  => 'integer',
            'keyword'                  => 'string',
            'start_time'               => 'string|date_format:Y-m-d',
            'end_time'                 => 'string|date_format:Y-m-d',
            'select_user_id'           => 'integer',
            'project_count_type'       => 'integer',
            'build_project_count_type' => 'integer',
            'future_potential_type'    => 'integer',
            'column'                   => 'string',
            'sort'                     => 'string',
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
            'company_id'               => '公司ID',
            'province_id'              => '省份',
            'city_id'                  => '城市',
            'user_id'                  => '用户ID',
            'keyword'                  => '关键词',
            'start_time'               => '开始时间',
            'end_time'                 => '结束时间',
            'select_user_id'           => '选择用户',
            'project_count_type'       => '项目数量类型',
            'build_project_count_type' => '在建项目数量类型',
            'future_potential_type'    => '未来潜量类型',
        ];
    }


    public function validation()
    {
        $this->customer_specification = new CustomerSpecification();

        if (array_get($this->data, 'company_id')) {
            $this->customer_specification->company_id = array_get($this->data, 'company_id');
        }

        if (array_get($this->data, 'province_id')) {
            $this->customer_specification->province_id = array_get($this->data, 'province_id');
        }
        if (array_get($this->data, 'city_id')) {
            $this->customer_specification->city_id = array_get($this->data, 'city_id');
        }


        if (array_get($this->data, 'start_time')) {
            $this->customer_specification->start_time = Carbon::parse(array_get($this->data, 'start_time'));
        }

        if (array_get($this->data, 'end_time')) {
            $this->customer_specification->end_time = Carbon::parse(array_get($this->data, 'end_time'));
        }

        if (array_get($this->data, 'user_id')) {
            $this->customer_specification->user_id = array_get($this->data, 'user_id');
        }

        if (array_get($this->data, 'keyword')) {
            $this->customer_specification->keyword = array_get($this->data, 'keyword');
        }

        if (array_get($this->data, 'select_user_id')) {
            $this->customer_specification->select_user_id = array_get($this->data, 'select_user_id');
        }

        //管理的数据权限
        if (!empty(array_get($this->data, 'user_ids'))) {
            $this->customer_specification->user_ids = array_get($this->data, 'user_ids');
        }

        if ($project_count_type = array_get($this->data, 'project_count_type')) {
            $project_count_limits = ProjectCountType::acceptableLimits();
            if (isset($project_count_limits[$project_count_type])) {
                $this->customer_specification->project_count_type = $project_count_type;
                $this->customer_specification->project_count_min = $project_count_limits[$project_count_type][0];
                $this->customer_specification->project_count_max = $project_count_limits[$project_count_type][1];
            }
        }

        if ($build_project_count_type = array_get($this->data, 'build_project_count_type')) {
            $build_project_count_limits = BuildProjectCountType::acceptableLimits();
            if (isset($build_project_count_limits[$build_project_count_type])) {
                $this->customer_specification->build_project_count_type = $build_project_count_type;
                $this->customer_specification->build_project_count_min = $build_project_count_limits[$build_project_count_type][0];
                $this->customer_specification->build_project_count_max = $build_project_count_limits[$build_project_count_type][1];
            }
        }

        if ($future_potential_type = array_get($this->data, 'future_potential_type')) {
            $future_potential_limits = FuturePotentialType::acceptableLimits();
            if (isset($future_potential_limits[$future_potential_type])) {
                $this->customer_specification->future_potential_type = $future_potential_type;
                $this->customer_specification->future_potential_min = $future_potential_limits[$future_potential_type][0];
                $this->customer_specification->future_potential_max = $future_potential_limits[$future_potential_type][1];
            }
        }

        if (array_get($this->data, 'column')) {
            $this->customer_specification->column = array_get($this->data, 'column');
        }

        if (array_get($this->data, 'sort')) {
            $this->customer_specification->sort = array_get($this->data, 'sort');
        }
    }
}