<?php namespace Huifang\Src\Surport\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface CountyInterface extends Repository
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();

}