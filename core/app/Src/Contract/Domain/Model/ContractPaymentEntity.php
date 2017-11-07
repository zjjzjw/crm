<?php
namespace Huifang\Src\Contract\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ContractPaymentEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $contract_id;

    /**
     * @var int
     */
    public $period;

    /**
     * @var float
     */
    public $payment_amount;

    /**
     * @var int
     */
    public $payment_type;

    /**
     * @var Carbon
     */
    public $payment_at;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $note;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'             => $this->id,
            'contract_id'    => $this->contract_id,
            'period'         => $this->period,
            'payment_amount' => $this->payment_amount,
            'payment_type'   => $this->payment_type,
            'payment_at'     => $this->payment_at->toDateTimeString(),
            'status'         => $this->status,
            'note'           => $this->note,
            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),
        ];
    }

}