<?php namespace Huifang\Src\Role\Infra\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDepartModel extends Model
{
    use SoftDeletes;
    protected $table = 'user_depart';

    protected $fillable = [
        'user_id',
        'depart_id',
    ];

}