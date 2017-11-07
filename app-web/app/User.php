<?php

namespace Huifang\Web;

use Huifang\Src\Company\Infra\Eloquent\CompanyModel;
use Huifang\Src\Role\Infra\Eloquent\RoleModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Collection;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, AuthorizableContract
{
    use Authenticatable, CanResetPassword, Authorizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * 用户权限
     * @var Collection
     */
    public static $permissions;

    /**
     * 是否超级管理员
     * @return boolean
     */
    public function isSuperAdmin()
    {
        return true;
    }

    public function hasPermission($route_name)
    {
        $bool = false;
        $config_permissions = config('permissions');
        $codes = $config_permissions[$route_name];
        if (self::$permissions == null) {
            $permissions = collect();
            foreach ($this->roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissions[] = $permission->toArray();
                }
            }
            self::$permissions = $permissions;
        }
        $bool = self::$permissions->contains(function ($key, $value) use ($codes) {
            if (is_array($codes)) {
                return in_array($value['code'], $codes);
            } else {
                return $value['code'] == $codes;
            }
        });
        return $bool;
    }

    /**
     * 用户所在的公司
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'company_id', 'id');
    }

    /**
     * 用户的角色
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'user_role', 'user_id', 'role_id');
    }

}
