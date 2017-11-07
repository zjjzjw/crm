<?php
namespace Huifang\Src\Sale\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleModel extends Model
{

    use SoftDeletes;

    protected $table = 'sale';

    protected $fillable = [
        'sn',
        'user_id',
        'company_id',
        'project_name',
        'province_id',
        'city_id',
        'county_id',
        'address',
        'developer_name',
        'developer_group_name',
        'project_volume',
        'project_step_id',
        'contact_name',
        'position_name',
        'contact_phone',
        'created_user_id',
        'status',
        'close_status',
        'close_reason',
    ];

}