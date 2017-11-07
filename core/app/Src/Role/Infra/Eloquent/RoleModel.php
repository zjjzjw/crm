<?php namespace Huifang\Src\Role\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model
{
    use SoftDeletes;

    protected $table = 'role';

    protected $fillable = [
        'company_id',
        'name',
        'desc',
    ];

    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, 'role_permission', 'role_id', 'permission_id');
    }


}