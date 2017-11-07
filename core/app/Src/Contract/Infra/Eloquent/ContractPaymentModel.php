<?php
namespace Huifang\Src\Contract\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractPaymentModel extends Model
{

    use SoftDeletes;

    protected $table = 'contract_payment';

    protected $dates = [
        'payment_at',
    ];

    protected $fillable = [
        'contract_id',
        'period',
        'payment_amount',
        'payment_type',
        'payment_at',
        'status',
        'note',
    ];
}