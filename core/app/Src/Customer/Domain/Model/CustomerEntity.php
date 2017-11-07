<?php
namespace Huifang\Src\Customer\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class CustomerEntity extends Entity
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
    public $customer_company_name;

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
     * @var int
     */
    public $project_count;

    /**
     * @var int
     */
    public $build_project_count;

    /**
     * @var int
     */
    public $future_potential;

    /**
     * @var string
     */
    public $record;

    /**
     * @var string
     */
    public $use_brand;

    /**
     * @var int
     */
    public $volume;

    /**
     * @var int
     */
    public $level;

    /**
     * 预计
     * @var Carbon
     */
    public $per_signed_at;

    /**
     * @var int
     */
    public $created_user_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'company_id'            => $this->company_id,
            'customer_company_name' => $this->customer_company_name,
            'province_id'           => $this->province_id,
            'city_id'               => $this->city_id,
            'contact_name'          => $this->contact_name,
            'position_name'         => $this->position_name,
            'contact_phone'         => $this->contact_phone,
            'project_count'         => $this->project_count,
            'build_project_count'   => $this->build_project_count,
            'future_potential'      => $this->future_potential,
            'record'                => $this->record,
            'use_brand'             => $this->use_brand,
            'volume'                => $this->volume,
            'level'                 => $this->level,
            'per_signed_at'         => $this->per_signed_at->toDateTimeString(),
            'created_user_id'       => $this->created_user_id,
        ];
    }

}