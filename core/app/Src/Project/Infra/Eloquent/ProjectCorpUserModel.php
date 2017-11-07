<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectCorpUserModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_corp_user';


    protected $fillable = [
        'project_id',
        'user_id',
    ];

}