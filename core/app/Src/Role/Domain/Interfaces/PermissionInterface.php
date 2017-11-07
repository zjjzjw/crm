<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface PermissionInterface extends Repository
{

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all();
}