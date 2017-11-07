<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectEntity extends Entity
{


    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $user_id;
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
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $developer_name;
    /**
     * @var int
     */
    public $project_volume;

    /**
     * @var string
     */
    public $contact_name;

    /**
     * @var string
     */
    public $contact_phone;

    /**
     * @var string
     */
    public $use_brands;
    /**
     * @var Carbon
     */
    public $signed_at;
    /**
     * @var string
     */
    public $created_user_id;

    /**
     * @var array
     */
    public $project_corp_user_ids;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'company_id'            => $this->company_id,
            'project_name'          => $this->project_name,
            'province_id'           => $this->province_id,
            'city_id'               => $this->city_id,
            'address'               => $this->address,
            'developer_name'        => $this->developer_name,
            'project_volume'        => $this->project_volume,
            'contact_name'          => $this->contact_name,
            'contact_phone'         => $this->contact_phone,
            'created_user_id'       => $this->created_user_id,
            'project_corp_user_ids' => $this->project_corp_user_ids,
            'use_brands'            => $this->use_brands,
            'signed_at'             => $this->signed_at->toDateTimeString(),
        ];
    }

}