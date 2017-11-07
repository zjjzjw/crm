<?php namespace Huifang\Src\Role\Infra\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoleModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_role';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

}