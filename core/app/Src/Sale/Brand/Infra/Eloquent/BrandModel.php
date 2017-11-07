<?php
namespace Huifang\Src\Sale\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand';

    protected $dates = [
    ];

    protected $fillable = [
        'company_id',
        'company_name',
        'brand_name',
    ];

}