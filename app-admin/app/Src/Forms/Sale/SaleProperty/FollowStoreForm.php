<?php

namespace Huifang\Admin\Src\Forms\Sale\SaleProperty;

use Huifang\Web\Src\Forms\Form;

class FollowStoreForm extends Form
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
            'id'                           => 'required|integer',
            'developer_group_id'           => 'integer',
            'strategy_id'                  => 'integer',
            'strategy_brand_other'         => 'string',
            'kitchen_budget'               => 'integer',
            'kitchen_configuration'        => 'integer',
            'contend_brand'                => 'string',
            'project_position'             => 'integer',
            'project_status'               => 'integer',
            'project_estimate_signed_time' => 'string',
            'project_estimate_price'       => 'string',
            'project_loss_reason'          => 'string',
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
            'developer_group_id'           => '开发商集团',
            'strategy_id'                  => '战略归属',
            'strategy_brand_other'         => '其他战略品牌',
            'kitchen_budget'               => '厨电预算',
            'kitchen_configuration'        => '厨电配置',
            'contend_brand'                => '竞争品牌',
            'project_position'             => '项目定位',
            'project_status'               => '项目状态',
            'project_estimate_signed_time' => '预估合同签订时间',
            'project_estimate_price'       => '项目金额',
            'project_estimate_status'      => '项目签约情况',
            'project_loss_reason'          => '项目丢失原因',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $data = [];
            $data['id'] = array_get($this->data, 'id');
            $data['developer_group_id'] = array_get($this->data, 'developer_group_id');
            $data['strategy_id'] = array_get($this->data, 'strategy_id');
            $data['strategy_brand_other'] = array_get($this->data, 'strategy_brand_other');
            $data['kitchen_budget'] = array_get($this->data, 'kitchen_budget');
            $data['kitchen_configuration'] = array_get($this->data, 'kitchen_configuration');
            $data['contend_brand'] = array_get($this->data, 'contend_brand');
            $data['project_position'] = array_get($this->data, 'project_position');
            $data['project_status'] = array_get($this->data, 'project_status');
            $data['project_estimate_signed_time'] = array_get($this->data, 'project_estimate_signed_time');
            $data['project_estimate_price'] = array_get($this->data, 'project_estimate_price');
            $data['project_estimate_status'] = array_get($this->data, 'project_estimate_status');
            $data['project_loss_reason'] = array_get($this->data, 'project_loss_reason');

            $this->sale_data = $data;
        }

    }

}