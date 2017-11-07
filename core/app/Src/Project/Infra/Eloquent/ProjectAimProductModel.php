<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAimProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'project_aim_product';

    protected $dates = [

    ];

    protected $fillable = [
        'project_aim_id',
        'product_id',
        'volume',
        'price',
    ];

}