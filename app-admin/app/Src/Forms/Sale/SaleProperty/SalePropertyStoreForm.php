<?php

namespace Huifang\Admin\Src\Forms\Sale\SaleProperty;

use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Src\Forms\Form;

class SalePropertyStoreForm extends Form
{

    /**
     * @var SaleEntity
     */
    public $sale_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                           => 'required|integer',
            'project_name'                 => 'required|string',
            'sn'                           => 'string',
            'province_id'                  => 'integer',
            'city_id'                      => 'integer',
            'county_id'                    => 'integer',
            'address'                      => 'string',
            'developer_name'               => 'string',
            'developer_group_name'         => 'string',
            'project_volume'               => 'integer',
            'project_step_id'              => 'integer',
            'contact_name'                 => 'string',
            'position_name'                => 'string',
            'contact_phone'                => 'string',
            'developer_id'                 => 'nullable|integer',
            'developer_group_id'           => 'nullable|integer',
            'record_time'                  => 'nullable|string',
            'project_region_id'            => 'nullable|integer',
            'sale_status'                  => 'nullable|integer',
            'building_developer_name'      => 'nullable|string',
            'decoration_type'              => 'nullable|integer',
            'house_total'                  => 'nullable|integer',
            'hardcover_standard'           => 'nullable|integer',
            'at_hardcover_house_total'     => 'nullable|integer',
            'floor_condition'              => 'nullable|string',
            'floor_total'                  => 'nullable|integer',
            'area_covered'                 => 'nullable|integer',
            'architecture_covered'         => 'nullable|integer',
            'project_schedule'             => 'nullable|integer',
            'property_type'                => 'nullable|integer',
            'property_company'             => 'nullable|string',
            'housing_price'                => 'nullable|integer',
            'has_sample_house'             => 'nullable|integer',
            'brand_id'                     => 'nullable|integer',
            'opening_time'                 => 'nullable|string',
            'handing_time'                 => 'nullable|string',
            'sale_phone'                   => 'nullable|string',
            'strategy_id'                  => 'nullable|integer',
            'strategy_brand_other'         => 'nullable|string',
            'kitchen_budget'               => 'nullable|integer',
            'kitchen_configuration'        => 'nullable|integer',
            'contend_brand'                => 'nullable|string',
            'project_position'             => 'nullable|integer',
            'project_status'               => 'nullable|integer',
            'project_estimate_signed_time' => 'nullable|string',
            'project_estimate_price'       => 'nullable|integer',
            'project_estimate_status'      => 'nullable|integer',
            'project_loss_reason'          => 'nullable|string',
            'remake'                       => 'nullable|string',
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
            'project_name'                 => '楼盘名称',
            'province_id'                  => '省',
            'city_id'                      => '城市',
            'address'                      => '地址',
            'developer_name'               => '开发商',
            'developer_group_name'         => '所属集团',
            'project_volume'               => '精装总用户',
            'project_step_id'              => '项目阶段',
            'contact_name'                 => '联系人',
            'position_name'                => '岗位',
            'contact_phone'                => '电话',
            'sale_id'                      => '销售线索id',
            'developer_id'                 => '开发商分公司id',
            'developer_group_id'           => '开发商集团id',
            'record_time'                  => '备案时间',
            'loupan_name'                  => '楼盘名称',
            'project_region_id'            => '工程大区划分id',
            'sale_status'                  => '销售状态',
            'building_developer_name'      => '建筑开发商',
            'decoration_type'              => '装修类别',
            'house_total'                  => '总户数',
            'hardcover_standard'           => '精装标准',
            'at_hardcover_house_total'     => '当前精装户数',
            'floor_condition'              => '楼层情况',
            'floor_total'                  => '楼栋总数',
            'area_covered'                 => '占地面积',
            'architecture_covered'         => '建筑面积',
            'project_schedule'             => '工程进度',
            'property_type'                => '物业类型',
            'property_company'             => '物业公司',
            'housing_price'                => '楼盘均价',
            'has_sample_house'             => '是否有样板房',
            'brand_id'                     => '样板房配套品牌id',
            'opening_time'                 => '开盘时间',
            'handing_time'                 => '交房时间',
            'sale_phone'                   => '售楼电话',
            'strategy_id'                  => '战略归属',
            'strategy_brand_other'         => '其他战略品牌',
            'kitchen_budget'               => '厨电预算',
            'kitchen_configuration'        => '厨电配置',
            'contend_brand'                => '竞争品牌',
            'project_position'             => '项目定位',
            'project_status'               => '项目状态',
            'project_estimate_signed_time' => '预估项目合同签约时间',
            'project_estimate_price'       => '项目签约金额',
            'project_estimate_status'      => '项目签约情况',
            'project_loss_reason'          => '项目丢失情况说明',
            'remake'                       => '备注',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $sale_repository = new SaleRepository();
            $this->sale_entity = $sale_repository->fetch(array_get($this->data, 'id'));
        } else {
            $this->sale_entity = new SaleEntity();
            $this->sale_entity->company_id = request()->user()->company->id;
        }
        $this->sale_entity->sn = array_get($this->data, 'sn') ?? '';
        $this->sale_entity->project_name = array_get($this->data, 'project_name');
        $this->sale_entity->province_id = array_get($this->data, 'province_id');
        $this->sale_entity->city_id = array_get($this->data, 'city_id');
        $this->sale_entity->address = array_get($this->data, 'address');
        $this->sale_entity->county_id = array_get($this->data, 'county_id') ?? 0;
        $this->sale_entity->developer_name = array_get($this->data, 'developer_name');
        $this->sale_entity->developer_group_name = array_get($this->data, 'developer_group_name');
        $this->sale_entity->project_volume = array_get($this->data, 'project_volume');
        $this->sale_entity->project_step_id = array_get($this->data, 'project_step_id');
        $this->sale_entity->contact_name = array_get($this->data, 'contact_name');
        $this->sale_entity->position_name = array_get($this->data, 'position_name');
        $this->sale_entity->contact_phone = array_get($this->data, 'contact_phone');


        $sale_property_data = [];
        $sale_property_data['developer_id'] = array_get($this->data, 'developer_id');
        $sale_property_data['developer_group_id'] = array_get($this->data, 'developer_group_id');
        $sale_property_data['record_time'] = array_get($this->data, 'record_time');
        $sale_property_data['loupan_name'] = array_get($this->data, 'project_name');
        $sale_property_data['project_region_id'] = array_get($this->data, 'project_region_id');
        $sale_property_data['sale_status'] = array_get($this->data, 'sale_status');
        $sale_property_data['building_developer_name'] = array_get($this->data, 'building_developer_name');
        $sale_property_data['decoration_type'] = array_get($this->data, 'decoration_type');
        $sale_property_data['house_total'] = array_get($this->data, 'house_total');
        $sale_property_data['hardcover_standard'] = array_get($this->data, 'hardcover_standard');
        $sale_property_data['at_hardcover_house_total'] = array_get($this->data, 'at_hardcover_house_total');
        $sale_property_data['floor_condition'] = array_get($this->data, 'floor_condition');
        $sale_property_data['floor_total'] = array_get($this->data, 'floor_total');
        $sale_property_data['area_covered'] = array_get($this->data, 'area_covered');
        $sale_property_data['architecture_covered'] = array_get($this->data, 'architecture_covered');
        $sale_property_data['project_schedule'] = array_get($this->data, 'project_schedule');
        $sale_property_data['property_type'] = array_get($this->data, 'property_type');
        $sale_property_data['property_company'] = array_get($this->data, 'property_company');
        $sale_property_data['housing_price'] = array_get($this->data, 'housing_price');
        $sale_property_data['has_sample_house'] = array_get($this->data, 'has_sample_house');
        $sale_property_data['brand_id'] = array_get($this->data, 'brand_id');
        $sale_property_data['opening_time'] = array_get($this->data, 'opening_time');
        $sale_property_data['handing_time'] = array_get($this->data, 'handing_time');
        $sale_property_data['sale_phone'] = array_get($this->data, 'sale_phone');
        $sale_property_data['strategy_id'] = array_get($this->data, 'strategy_id');
        $sale_property_data['strategy_brand_other'] = array_get($this->data, 'strategy_brand_other');
        $sale_property_data['kitchen_budget'] = array_get($this->data, 'kitchen_budget');
        $sale_property_data['kitchen_configuration'] = array_get($this->data, 'kitchen_configuration');
        $sale_property_data['contend_brand'] = array_get($this->data, 'contend_brand');
        $sale_property_data['project_position'] = array_get($this->data, 'project_position');
        $sale_property_data['project_status'] = array_get($this->data, 'project_status');
        $sale_property_data['project_estimate_signed_time'] = array_get($this->data, 'project_estimate_signed_time');
        $sale_property_data['project_estimate_price'] = array_get($this->data, 'project_estimate_price');
        $sale_property_data['project_estimate_status'] = array_get($this->data, 'project_estimate_status');
        $sale_property_data['project_loss_reason'] = array_get($this->data, 'project_loss_reason');
        $sale_property_data['remake'] = array_get($this->data, 'remake');

        $this->sale_entity->sale_property = $sale_property_data;

    }

}