<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectCorpUserEntity extends Entity
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
    public $project_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'project_id' => $this->project_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}