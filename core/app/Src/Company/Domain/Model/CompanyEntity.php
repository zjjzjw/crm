<?php
namespace Huifang\Src\Company\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class CompanyEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $name;

    /**
     * @var Carbon
     */
    public $start_time;

    /**
     * @var Carbon
     */
    public $end_time;

    /**
     * @var int
     */
    public $user_number;

    /**
     * @var int
     */
    public $is_free;

    /**
     * @var string
     */
    public $created_user_id;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'start_time'      => $this->start_time->toDateTimeString(),
            'end_time'        => $this->end_time->toDateTimeString(),
            'user_number'     => $this->user_number,
            'is_free'         => $this->is_free,
            'created_user_id' => $this->created_user_id,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }

}