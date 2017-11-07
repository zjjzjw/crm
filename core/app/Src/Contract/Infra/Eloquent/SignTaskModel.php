<?php
namespace Huifang\Src\Contract\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignTaskModel extends Model
{

    use SoftDeletes;

    protected $table = 'sign_task';


    protected $fillable = [
        'user_id',
        'month',
        'amount',
    ];
}