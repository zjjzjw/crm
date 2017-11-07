<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectModel extends Model
{

    use SoftDeletes;

    protected $table = 'project';

    protected $dates = [
        'signed_at',
    ];


    protected $fillable = [
        'user_id',
        'company_id',
        'project_name',
        'province_id',
        'city_id',
        'address',
        'developer_name',
        'project_volume',
        'contact_name',
        'contact_phone',
        'created_user_id',
        'use_brands',
        'signed_at',
    ];

    public function project_corp_users()
    {
        return $this->hasMany(ProjectCorpUserModel::class, 'project_id', 'id');
    }
}