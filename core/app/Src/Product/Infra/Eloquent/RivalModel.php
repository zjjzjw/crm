<?php
namespace Huifang\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RivalModel extends Model
{
    use SoftDeletes;

    protected $table = 'rival';

    protected $dates = [
    ];

    protected $fillable = [
        'company_id',
        'name',
    ];

}