<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPurchaseModel extends Model
{
    use SoftDeletes;

    protected $table = 'project_purchase';

    protected $dates = [
        'timed_at',
    ];

    protected $fillable = [
        'project_id',
        'name',
        'personnel',
        'timed_at',
        'event_desc',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id', 'id');
    }
}