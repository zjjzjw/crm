<?php
namespace Huifang\Src\Contract\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractModel extends Model
{

    use SoftDeletes;

    protected $table = 'contract';

    protected $dates = [
        'signed_at',
        'expected_return_at',
        'tail_amount_at',
        'product_delivery_at',
    ];

    protected $fillable = [
        'user_id',
        'company_id',
        'contract_number',
        'contract_name',
        'signed_at',
        'customer_id',
        'customer_name',
        'product_id',
        'product_number',
        'product_price',
        'contract_amount',
        'down_payment',
        'expected_return_at',
        'tail_amount',
        'tail_amount_at',
        'product_delivery_at',
        'created_user_id',
    ];


    public function contract_products()
    {
        return $this->hasMany(ContractProductModel::class, 'contract_id', 'id');
    }

}