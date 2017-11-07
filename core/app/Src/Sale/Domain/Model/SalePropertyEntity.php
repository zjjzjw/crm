<?php

namespace Huifang\Src\Sale\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class SalePropertyEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $sale_id;

    /**
     * @var int
     */
    public $developer_id;

    /**
     * @var int
     */
    public $developer_group_id;

    /**
     * @var Carbon
     */
    public $record_time;

    /**
     * @var string
     */
    public $loupan_name;

    /**
     * @var int
     */
    public $project_region_id;

    /**
     * @var int
     */
    public $sale_status;

    /**
     * @var string
     */
    public $building_developer_name;

    /**
     * @var int
     */
    public $decoration_type;

    /**
     * @var int
     */
    public $house_total;

    /**
     * @var int
     */
    public $hardcover_standard;

    /**
     * @var int
     */
    public $at_hardcover_house_total;

    /**
     * @var string
     */
    public $floor_condition;

    /**
     * @var int
     */
    public $floor_total;

    /**
     * @var int
     */
    public $area_covered;

    /**
     * @var int
     */
    public $architecture_covered;

    /**
     * @var int
     */
    public $project_schedule;

    /**
     * @var int
     */
    public $property_type;

    /**
     * @var string
     */
    public $property_company;

    /**
     * @var int
     */
    public $housing_price;

    /**
     * @var int
     */
    public $has_sample_house;

    /**
     * @var int
     */
    public $brand_id;

    /**
     * @var Carbon
     */
    public $opening_time;

    /**
     * @var Carbon
     */
    public $handing_time;

    /**
     * @var string
     */
    public $sale_phone;

    /**
     * @var int
     */
    public $strategy_id;

    /**
     * @var string
     */
    public $strategy_brand_other;

    /**
     * @var int
     */
    public $kitchen_budget;

    /**
     * @var int
     */
    public $kitchen_configuration;

    /**
     * @var string
     */
    public $contend_brand;

    /**
     * @var int
     */
    public $project_position;

    /**
     * @var int
     */
    public $project_status;

    /**
     * @var Carbon
     */
    public $project_estimate_signed_time;

    /**
     * @var int
     */
    public $project_estimate_price;

    /**
     * @var int
     */
    public $project_estimate_status;

    /**
     * @var string
     */
    public $project_loss_reason;

    /**
     * @var string
     */
    public $remake;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                           => $this->id,
            'sale_id'                      => $this->sale_id,
            'developer_id'                 => $this->developer_id,
            'developer_group_id'           => $this->developer_group_id,
            'record_time'                  => $this->record_time,
            'loupan_name'                  => $this->loupan_name,
            'project_region_id'            => $this->project_region_id,
            'sale_status'                  => $this->sale_status,
            'building_developer_name'      => $this->building_developer_name,
            'decoration_type'              => $this->decoration_type,
            'house_total'                  => $this->house_total,
            'hardcover_standard'           => $this->hardcover_standard,
            'at_hardcover_house_total'     => $this->at_hardcover_house_total,
            'floor_condition'              => $this->floor_condition,
            'floor_total'                  => $this->floor_total,
            'area_covered'                 => $this->area_covered,
            'architecture_covered'         => $this->architecture_covered,
            'project_schedule'             => $this->project_schedule,
            'property_type'                => $this->property_type,
            'property_company'             => $this->property_company,
            'housing_price'                => $this->housing_price,
            'has_sample_house'             => $this->has_sample_house,
            'brand_id'                     => $this->brand_id,
            'opening_time'                 => $this->opening_time,
            'handing_time'                 => $this->handing_time,
            'sale_phone'                   => $this->sale_phone,
            'strategy_id'                  => $this->strategy_id,
            'strategy_brand_other'         => $this->strategy_brand_other,
            'kitchen_budget'               => $this->kitchen_budget,
            'kitchen_configuration'        => $this->kitchen_configuration,
            'contend_brand'                => $this->contend_brand,
            'project_position'             => $this->project_position,
            'project_status'               => $this->project_status,
            'project_estimate_signed_time' => $this->project_estimate_signed_time,
            'project_estimate_price'       => $this->project_estimate_price,
            'project_estimate_status'      => $this->project_estimate_status,
            'project_loss_reason'          => $this->project_loss_reason,
            'remake'                       => $this->remake,
        ];
    }

}