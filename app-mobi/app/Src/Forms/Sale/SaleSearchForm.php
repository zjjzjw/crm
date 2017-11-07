<?php

namespace Huifang\Mobi\Src\Forms\Sale;

use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Mobi\Src\Forms\Form;

class SaleSearchForm extends Form
{

    /**
     * @var SaleSpecification
     */
    public $sale_specification;

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
            'project_step_type'   => 'integer',
            'project_volume_type' => 'integer',
            'user_id'             => 'integer',
            'keyword'             => 'string',
            'user_ids'            => 'array',
            'select_user_id'      => 'integer',
            'status'              => 'integer',
            'sort'                => 'string',
            'column'              => 'string',
            'close_status'        => 'integer',
            'page'                => 'integer',
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
            'province_id'         => '省份',
            'city_id'             => '城市',
            'company_id'          => '公司',
            'project_step_type'   => '工程阶段',
            'project_volume_type' => '工程体量',
            'user_id'             => '用户ID',
            'keyword'             => '关键词',
            'select_user_id'      => '选择用户ID',
            'close_status'        => '关闭销售线索',
        ];
    }


    public function validation()
    {
        $this->sale_specification = new SaleSpecification();
        if (array_get($this->data, 'province_id')) {
            $this->sale_specification->province_id = array_get($this->data, 'province_id');
        }
        if (array_get($this->data, 'city_id')) {
            $this->sale_specification->city_id = array_get($this->data, 'city_id');
        }
        if (array_get($this->data, 'project_step_type')) {
            $this->sale_specification->project_step_type = array_get($this->data, 'project_step_type');
        }

        if (array_get($this->data, 'project_volume_type')) {
            $this->sale_specification->project_volume_type = array_get($this->data, 'project_volume_type');
            $project_volume_limits = ProjectVolumeType::acceptableLimits();
            if (isset($project_volume_limits[$this->sale_specification->project_volume_type])) {
                $this->sale_specification->project_volume_min =
                    $project_volume_limits[$this->sale_specification->project_volume_type][0];
                $this->sale_specification->project_volume_max =
                    $project_volume_limits[$this->sale_specification->project_volume_type][1];
            }
        }
        if (array_get($this->data, 'user_id')) {
            $this->sale_specification->user_id = array_get($this->data, 'user_id');
        }

        if (array_get($this->data, 'keyword')) {
            $this->sale_specification->keyword = array_get($this->data, 'keyword');
        }
        if (array_get($this->data, 'company_id')) {
            $this->sale_specification->company_id = array_get($this->data, 'company_id');
        }

        if (array_get($this->data, 'select_user_id')) {
            $this->sale_specification->select_user_id = array_get($this->data, 'select_user_id');
        }

        if (array_get($this->data, 'status')) {
            $this->sale_specification->status = array_get($this->data, 'status');
        }

        $this->sale_specification->user_ids = array_get($this->data, 'user_ids');

        //当状态为认领的时候,user_ids加入0
        if ($this->sale_specification->status == SaleStatus::TO_ASSIGN) {
            if (isset($this->sale_specification->user_ids)) {
                $this->sale_specification->user_ids = array_merge($this->sale_specification->user_ids, [0]);
            }
        }
        $this->sale_specification->sort = array_get($this->data, 'sort');
        $this->sale_specification->column = array_get($this->data, 'column');
        $this->sale_specification->close_status = array_get($this->data, 'close_status');

        $this->sale_specification->page = array_get($this->data, 'page');

    }

}