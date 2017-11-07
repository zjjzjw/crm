<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectAnalyseEntity extends Entity
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
    public $event_desc;

    /**
     * @var int
     */
    public $analyse_type;

    /**
     * @var int
     */
    public $swot_type;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'           => $this->id,
            'project_id'   => $this->project_id,
            'event_desc'   => $this->event_desc,
            'analyse_type' => $this->analyse_type,
            'swot_type'    => $this->swot_type,
            'created_at'   => $this->created_at->toDateTimeString(),
            'updated_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}