<?php
namespace Huifang\Src\Sale\LargeArea\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LargeAreaModel extends Model
{
    use SoftDeletes;

    protected $table = 'large_area';

    protected $dates = [
    ];

    protected $fillable = [
        'company_id',
        'name',
    ];

}