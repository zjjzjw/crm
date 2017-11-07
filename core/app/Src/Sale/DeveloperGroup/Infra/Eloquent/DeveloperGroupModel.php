<?php
namespace Huifang\Src\Sale\DeveloperGroup\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperGroupModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_group';

    protected $dates = [
    ];

    protected $fillable = [
        'company_id',
        'name',
    ];

}