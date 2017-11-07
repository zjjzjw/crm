<?php namespace Huifang\Src\Surport\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface CityInterface extends Repository
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();

}