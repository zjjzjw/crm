<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectAimHinderEntity extends Entity
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
     * @var int
     */
    public $aim_id;
    /**
     * @var string
     */
    public $hinder_name;

    /**
     * @var string
     */
    public $implementation_plan;

    /**
     * @var int
     */
    public $project_purchase_id;

    /**
     * @var string
     */
    public $feedback;

    /**
     * @var string
     */
    public $resource_application;

    /**
     * @var Carbon
     */
    public $executed_at;

    /**
     * @var int
     */
    public $status;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                   => $this->id,
            'project_id'           => $this->project_id,
            'aim_id'               => $this->aim_id,
            'hinder_name'          => $this->hinder_name,
            'implementation_plan'  => $this->implementation_plan,
            'project_purchase_id'  => $this->project_purchase_id,
            'feedback'             => $this->feedback,
            'resource_application' => $this->resource_application,
            'status'               => $this->status,
            'executed_at'          => $this->executed_at->toDateTimeString(),
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }
}