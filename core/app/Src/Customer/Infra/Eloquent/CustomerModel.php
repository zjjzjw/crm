<?php
namespace Huifang\Src\Customer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerModel extends Model
{

    use SoftDeletes;

    protected $table = 'customer';

    protected $dates = [
        'per_signed_at',
    ];

    protected $fillable = [
        'user_id',
        'company_id',
        'customer_company_name',
        'province_id',
        'city_id',
        'contact_name',
        'position_name',
        'contact_phone',
        'project_count',
        'build_project_count',
        'future_potential',
        'record',
        'use_brand',
        'volume',
        'level',
        'per_signed_at',
        'created_user_id',
    ];
}