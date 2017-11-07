<?php
namespace Huifang\Src\Contract\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'contract_product';

    protected $fillable = [
        'contract_id',
        'product_id',
        'product_number',
        'product_price',
    ];
}