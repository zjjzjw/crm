<?php

namespace Huifang\Mobi\Src\Forms\Sale;

use Huifang\Service\Role\TokenService;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Mobi\Src\Forms\Form;
use SuperClosure\Analyzer\Token;

class SaleStoreForm extends Form
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
            'id'                   => 'required|integer',
            'sn'                   => 'nullable|integer',
            'project_name'         => 'required|string',
            'province_id'          => 'required|integer',
            'city_id'              => 'required|integer',
            'county_id'            => 'nullable|integer',
            'address'              => 'required|string',
            'developer_name'       => 'required|string',
            'developer_group_name' => 'required|string',
            'project_volume'       => 'required|integer',
            'project_step_id'      => 'required|integer',
            'contact_name'         => 'required|string',
            'position_name'        => 'required|string',
            'contact_phone'        => 'required|string',
            'close_status'         => 'required|integer',
            'close_reason'         => 'string',
        ];
    }


    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute整型',
            'string'      => ':attribute字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id'                   => '主键',
            'project_name'         => '项目名称',
            'province_id'          => '省份',
            'city_id'              => '城市',
            'address'              => '详细地址',
            'developer_name'       => '所属开发商',
            'developer_group_name' => '所属开发商集团名称',
            'project_volume'       => '体量',
            'project_step_id'      => '阶段',
            'contact_name'         => '联系人名称',
            'position_name'        => '联系喜人职位',
            'contact_phone'        => '联系人电话',
            'close_status'         => '关闭销售线索',
            'close_reason'         => '关闭原因',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $id = array_get($this->data, 'id');
            $sale_repository = new SaleRepository();
            $sale_entity = $sale_repository->fetch($id);
        } else {
            $sale_entity = new SaleEntity();
            //得到创建者
            $sale_entity->created_user_id = TokenService::$user_id;
            $sale_entity->user_id = TokenService::$user_id;
            $user_entity = TokenService::getUserEntity();
            $company_id = $user_entity->company_id;
            $sale_entity->company_id = $company_id;
            $sale_entity->status = SaleStatus::ASSIGNED; //自己创建的默认是已认领
        }
        $sale_entity->project_name = array_get($this->data, 'project_name');
        $sale_entity->sn = array_get($this->data, 'sn') ?? '';
        $sale_entity->province_id = array_get($this->data, 'province_id');
        $sale_entity->city_id = array_get($this->data, 'city_id');
        $sale_entity->county_id = array_get($this->data, 'county_id') ?? 0;
        $sale_entity->address = array_get($this->data, 'address');
        $sale_entity->developer_name = array_get($this->data, 'developer_name');
        $sale_entity->developer_group_name = array_get($this->data, 'developer_group_name');
        $sale_entity->project_volume = array_get($this->data, 'project_volume');
        $sale_entity->project_step_id = array_get($this->data, 'project_step_id');
        $sale_entity->contact_name = array_get($this->data, 'contact_name');
        $sale_entity->position_name = array_get($this->data, 'position_name');
        $sale_entity->contact_phone = array_get($this->data, 'contact_phone');
        $sale_entity->close_status = array_get($this->data, 'close_status');
        $sale_entity->close_reason = array_get($this->data, 'close_reason', '');

        $this->validateEditSale();

        $this->sale_entity = $sale_entity;
    }

    /**
     * 判断是否对本条数据有编辑权限
     */
    public function validateEditSale()
    {
        $sale_repository = new SaleRepository();
        if (array_get($this->data, 'id')) {
            /** @var SaleEntity $sale_entity */
            $sale_entity = $sale_repository->fetch(array_get($this->data, 'id'));
            if (isset($sale_entity) && $sale_entity->user_id != TokenService::$user_id) {
                $this->addError('permission', '不能编辑他人负责的销售线索！');
            }
        }
    }

}