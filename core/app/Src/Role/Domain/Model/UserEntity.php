<?php
namespace Huifang\Src\Role\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class UserEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $company_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $password;

    /**
     * @var Carbon
     */
    public $start_time;

    /**
     * @var Carbon
     */
    public $end_time;

    /**
     * @var string
     */
    public $created_user_id;


    /**
     * 权限只做到角色
     * @var array
     */
    public $role_ids;

    /**
     * 用户头像
     * @var integer
     */
    public $image_id;


    /**
     * @var array
     */
    public $roles;

    /**
     *
     * @var array
     */
    public $depart_ids;

    /**
     * @var array
     */
    public $departs;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'              => $this->id,
            'company_id'      => $this->company_id,
            'name'            => $this->name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'password'        => $this->password,
            'created_user_id' => $this->created_user_id,
            'start_time'      => $this->start_time->toDateTimeString(),
            'end_time'        => $this->end_time->toDateTimeString(),
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
            'roles'           => $this->roles,
            'departs'         => $this->departs,
            'role_ids'        => $this->role_ids,
            'depart_ids'      => $this->depart_ids,
            'image_id'        => $this->image_id,
        ];
    }

}