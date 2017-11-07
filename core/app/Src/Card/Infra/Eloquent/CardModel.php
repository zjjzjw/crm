<?php
namespace Huifang\Src\Card\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardModel extends Model
{
    use SoftDeletes;

    protected $table = 'card';

    protected $fillable = [
        'company_id',
        'user_id',
        'name',
        'initials',
        'full_pinyin',
        'phone',
        'tel',
        'email',
        'position_name',
        'company_name',
        'address',
        'zip_code',
    ];

}