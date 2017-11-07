<?php
namespace Huifang\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFileCommentModel extends Model
{

    use SoftDeletes;

    protected $table = 'project_file_comment';

    protected $dates = [

    ];

    protected $fillable = [
        'project_file_id',
        'comment',
    ];
}