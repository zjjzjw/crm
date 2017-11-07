<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFileModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_file';

    protected $dates = [

    ];

    protected $fillable = [
        'project_id',
        'history_brands',
        'cooperation_brands',
        'tender_reason',
        'bench_brands',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id', 'id');
    }

    public function project_file_info()
    {
        return $this->hasMany(ProjectFileInfoModel::class, 'project_file_id', 'id');

    }

    public function project_file_comment()
    {
        return $this->hasMany(ProjectFileCommentModel::class, 'project_file_id', 'id');

    }
}