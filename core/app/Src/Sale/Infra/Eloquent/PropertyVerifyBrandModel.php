<?php
namespace Huifang\Src\Sale\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyVerifyBrandModel extends Model
{

    use SoftDeletes;

    protected $table = 'property_verify_brand';

    protected $fillable = [
        
    ];

}