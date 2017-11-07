<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectPurchaseEntity extends Entity
{

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $id;


    /**
     * @var int
     */
    public $project_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $personnel;

    /**
     * @var Carbon
     */
    public $timed_at;

    /**
     * @var string
     */
    public $event_desc;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'project_id' => $this->project_id,
            'name'       => $this->name,
            'personnel'  => $this->personnel,
            'timed_at'   => $this->timed_at->toDateTimeString(),
            'event_desc' => $this->event_desc,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}