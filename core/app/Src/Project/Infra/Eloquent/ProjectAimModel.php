<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAimModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_aim';

    protected $dates = [

    ];

    protected $fillable = [
        'project_id',
        'name',
        'product_ids',
        'price',
        'volume',
        'pain_analysis',
        'other',
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id', 'id');
    }

    public function project_aim_products()
    {
        return $this->hasMany(ProjectAimProductModel::class, 'project_aim_id', 'id');
    }
}