<?php

namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class SaleEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $user_id;

    /**
     * @var string
     */
    public $sn;

    /**
     * @var int
     */
    public $company_id;
    /**
     * @var string
     */
    public $project_name;
    /**
     * @var int
     */
    public $province_id;
    /**
     * @var int
     */
    public $city_id;

    /**
     * @var int
     */
    public $county_id;

    /**
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $developer_name;
    /**
     * @var string
     */
    public $developer_group_name;
    /**
     * @var int
     */
    public $project_volume;
    /**
     * @var int
     */
    public $project_step_id;
    /**
     * @var string
     */
    public $contact_name;
    /**
     * @var string
     */
    public $position_name;
    /**
     * @var string
     */
    public $contact_phone;
    /**
     * @var string
     */
    public $created_user_id;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $close_status;

    /**
     * @var string
     */
    public $close_reason;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                   => $this->id,
            'user_id'              => $this->user_id,
            'sn'                   => $this->sn,
            'company_id'           => $this->company_id,
            'project_name'         => $this->project_name,
            'province_id'          => $this->province_id,
            'city_id'              => $this->city_id,
            'county_id'            => $this->county_id,
            'address'              => $this->address,
            'developer_name'       => $this->developer_name,
            'developer_group_name' => $this->developer_group_name,
            'project_volume'       => $this->project_volume,
            'project_step_id'      => $this->project_step_id,
            'contact_name'         => $this->contact_name,
            'position_name'        => $this->position_name,
            'contact_phone'        => $this->contact_phone,
            'created_user_id'      => $this->created_user_id,
            'status'               => $this->status,
            'close_status'         => $this->close_status,
            'close_reason'         => $this->close_reason,
        ];
    }

}