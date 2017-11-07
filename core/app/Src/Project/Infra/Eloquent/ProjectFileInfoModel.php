<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFileInfoModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_file_info';

    protected $dates = [

    ];

    protected $fillable = [
        'project_file_id',
        'file_model',
        'price',
    ];
}