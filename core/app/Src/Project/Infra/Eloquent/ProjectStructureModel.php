<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStructureModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_structure';

    protected $dates = [

    ];

    protected $fillable = [
        'parent_id',
        'project_id',
        'name',
        'position_name',
        'contact_phone',
        'structure_role_id',
        'current_related_id',
        'character',
        'interest',
        'breakthrough_plan',
        'feedback',
        'proof',
        'pain_desc',
        'support_type',
        'structure_type',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id', 'id');
    }
}