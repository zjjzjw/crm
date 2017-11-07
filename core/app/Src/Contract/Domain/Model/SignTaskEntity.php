<?php
namespace Huifang\Src\Contract\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class SignTaskEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $month;

    /**
     * @var float
     */
    public $amount;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'month'      => $this->month,
            'amount'     => $this->amount,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}