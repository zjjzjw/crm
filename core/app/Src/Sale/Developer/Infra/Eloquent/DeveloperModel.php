<?php
namespace Huifang\Src\Sale\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer';

    protected $dates = [
    ];

    protected $fillable = [
        'company_id',
        'province_id',
        'city_id',
        'name',
    ];

}