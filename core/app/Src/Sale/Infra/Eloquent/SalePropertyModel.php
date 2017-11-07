<?php
namespace Huifang\Src\Sale\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalePropertyModel extends Model
{

    use SoftDeletes;

    protected $table = 'sale_property';

    protected $fillable = [
        'sale_id',
        'developer_id',
        'developer_group_id',
        'record_time',
        'loupan_name',
        'project_region_id',
        'sale_status',
        'building_developer_name',
        'decoration_type',
        'house_total',
        'hardcover_standard',
        'at_hardcover_house_total',
        'floor_condition',
        'floor_total',
        'area_covered',
        'architecture_covered',
        'project_schedule',
        'property_type',
        'property_company',
        'housing_price',
        'has_sample_house',
        'brand_id',
        'opening_time',
        'handing_time',
        'sale_phone',
        'strategy_id',
        'strategy_brand_other',
        'kitchen_budget',
        'kitchen_configuration',
        'contend_brand',
        'project_position',
        'project_status',
        'project_estimate_signed_time',
        'project_estimate_price',
        'project_estimate_status',
        'project_loss_reason',
        'remake',
    ];

}