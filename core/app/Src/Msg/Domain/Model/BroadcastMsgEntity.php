<?php
namespace Huifang\Src\Msg\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class BroadcastMsgEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $from_uid;

    /**
     * @var int
     */
    public $msg_id;

    /**
     * @var int
     */
    public $msg_type;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'from_uid'   => $this->from_uid,
            'msg_id'     => $this->msg_id,
            'msg_type'   => $this->msg_type,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}