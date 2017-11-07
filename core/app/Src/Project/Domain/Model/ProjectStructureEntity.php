<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectStructureEntity extends Entity
{

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $parent_id;

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
    public $position_name;


    /**
     * @var string
     */
    public $contact_phone;

    /**
     * @var int
     */
    public $structure_role_id;

    /**
     * @var int
     */
    public $current_related_id;

    /**
     * @var string
     */
    public $character;

    /**
     * @var string
     */
    public $interest;

    /**
     * @var string
     */
    public $breakthrough_plan;

    /**
     * @var int
     */
    public $feedback;

    /*
     * @var string
     */
    public $proof;

    /**
     * @var string
     */
    public $pain_desc;

    /**
     * @var int
     */
    public $support_type;

    /**
     * @var int
     */
    public $structure_type;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                 => $this->id,
            'parent_id'          => $this->parent_id,
            'project_id'         => $this->project_id,
            'name'               => $this->name,
            'position_name'      => $this->position_name,
            'contact_phone'      => $this->contact_phone,
            'structure_role_id'  => $this->structure_role_id,
            'current_related_id' => $this->current_related_id,
            'character'          => $this->character,
            'interest'           => $this->interest,
            'breakthrough_plan'  => $this->breakthrough_plan,
            'feedback'           => $this->feedback,
            'proof'              => $this->proof,
            'pain_desc'          => $this->pain_desc,
            'support_type'       => $this->support_type,
            'structure_type'     => $this->structure_type,
            'created_at'         => $this->created_at->toDateTimeString(),
            'updated_at'         => $this->updated_at->toDateTimeString(),
        ];
    }
}