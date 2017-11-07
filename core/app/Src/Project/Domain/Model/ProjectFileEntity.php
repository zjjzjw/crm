<?php

namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectFileEntity extends Entity
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
    public $history_brands;

    /**
     * @var string
     */
    public $cooperation_brands;

    /**
     * @var string
     */
    public $tender_reason;

    /**
     * @var string
     */
    public $bench_brands;

    /**
     * @var array
     */
    public $project_file_info;

    /**
     * @var array
     */
    public $project_file_comment;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                   => $this->id,
            'project_id'           => $this->project_id,
            'history_brands'       => $this->history_brands,
            'cooperation_brands'   => $this->cooperation_brands,
            'bench_brands'         => $this->bench_brands,
            'tender_reason'        => $this->tender_reason,
            'project_file_info'    => $this->project_file_info,
            'project_file_comment' => $this->project_file_comment,
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }
}