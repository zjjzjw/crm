<?php namespace Huifang\Src\Role\Infra\Eloquent;


use Huifang\Web\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartModel extends Model
{
    use SoftDeletes;
    protected $table = 'depart';

    protected $fillable = [
        'company_id',
        'parent_id',
        'name',
        'desc',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_depart', 'depart_id', 'user_id');
    }

}