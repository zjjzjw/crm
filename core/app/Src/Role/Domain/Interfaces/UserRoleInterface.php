<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface UserRoleInterface extends Repository
{

    /**
     * @param int $role_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserRoleByRoleId($role_id);

}