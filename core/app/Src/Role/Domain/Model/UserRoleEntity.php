<?php
namespace Huifang\Src\Role\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class UserRoleEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';
    /**
     * @var int
     */
    public $user_id;
    /**
     * @var int
     */
    public $role_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'      => $this->id,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
        ];
    }

}