<?php

namespace Huifang\Admin\Src\Forms\Sale\SaleProperty;

use Huifang\Web\Src\Forms\Form;

class BuildingStoreForm extends Form
{

    /**
     * @var array
     */
    public $sale_data;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                       => 'required|integer',
            'building_developer_name'  => 'string',
            'decoration_type'          => 'integer',
            'house_total'              => 'integer',
            'hardcover_standard'       => 'string',
            'at_hardcover_house_total' => 'string',
            'floor_condition'          => 'string',
            'area_covered'             => 'integer',
            'architecture_covered'     => 'integer',
            'floor_total'              => 'integer',
            'project_schedule'         => 'integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'max'         => ':attribute最大长度',
        ];
    }

    public function attributes()
    {
        return [
            'building_developer_name'  => '建筑开发商名称',
            'decoration_type'          => '装修类别',
            'house_total'              => '总户数',
            'floor_condition'          => '楼层情况',
            'hardcover_standard'       => '精装修标准（元/m2）',
            'at_hardcover_house_total' => '楼层情况',
            'area_covered'             => '占地面积',
            'architecture_covered'     => '建筑面积',
            'floor_total'              => '楼栋总数',
            'project_schedule'         => '工程进度',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $data = [];
            $data['id'] = array_get($this->data, 'id');
            $data['building_developer_name'] = array_get($this->data, 'building_developer_name');
            $data['decoration_type'] = array_get($this->data, 'decoration_type');
            $data['house_total'] = array_get($this->data, 'house_total');
            $data['hardcover_standard'] = array_get($this->data, 'hardcover_standard');
            $data['at_hardcover_house_total'] = array_get($this->data, 'at_hardcover_house_total');
            $data['area_covered'] = array_get($this->data, 'area_covered');
            $data['architecture_covered'] = array_get($this->data, 'architecture_covered');
            $data['floor_total'] = array_get($this->data, 'floor_total');
            $data['project_schedule'] = array_get($this->data, 'project_schedule');
            $data['floor_condition'] = array_get($this->data, 'floor_condition');

            $this->sale_data = $data;
        }

    }

}