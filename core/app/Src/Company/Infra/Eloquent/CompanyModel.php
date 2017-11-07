<?php
namespace Huifang\Src\Company\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyModel extends Model
{
    use SoftDeletes;

    protected $table = 'company';

    protected $dates = [
        'start_time',
        'end_time',
    ];

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'user_number',
        'is_free',
        'created_user_id',
    ];
}