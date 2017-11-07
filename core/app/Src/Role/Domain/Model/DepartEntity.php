<?php

namespace Huifang\Src\Role\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class DepartEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $parent_id;

    /**
     * @var Carbon
     */
    public $name;

    /**
     * @var int
     */
    public $desc;

    /**
     * @var array
     */
    public $users;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'company_id' => $this->company_id,
            'parent_id'  => $this->parent_id,
            'name'       => $this->name,
            'desc'       => $this->desc,
            'users'      => $this->users,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}