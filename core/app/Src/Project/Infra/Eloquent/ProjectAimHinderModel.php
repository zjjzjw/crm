<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAimHinderModel extends Model
{
    use SoftDeletes;

    protected $table = 'project_aim_hinder';

    protected $dates = [
        'executed_at',
    ];

    protected $fillable = [
        'project_id',
        'aim_id',
        'hinder_name',
        'implementation_plan',
        'project_purchase_id',
        'feedback',
        'resource_application',
        'executed_at',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id', 'id');
    }

    public function project_aim()
    {
        return $this->belongsTo(ProjectAimModel::class, 'aim_id', 'id');
    }
}