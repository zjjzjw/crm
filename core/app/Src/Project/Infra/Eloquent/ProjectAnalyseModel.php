<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAnalyseModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_analyse';

    protected $dates = [

    ];

    protected $fillable = [
        'project_id',
        'event_desc',
        'analyse_type',
        'swot_type',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id', 'id');
    }
}