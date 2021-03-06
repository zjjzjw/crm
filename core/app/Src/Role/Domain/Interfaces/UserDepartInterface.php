<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface UserDepartInterface extends Repository
{

    /**
     * @param int $depart_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserDepartByDepartId($depart_id);
}