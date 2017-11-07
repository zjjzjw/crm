<?php
namespace Huifang\Src\Role\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class RoleEntity extends Entity
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
    public $permissions;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'company_id'  => $this->company_id,
            'name'        => $this->name,
            'desc'        => $this->desc,
            'permissions' => $this->permissions,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }

}