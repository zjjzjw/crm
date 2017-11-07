<?php

namespace Huifang\Src\Surport\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class CountyEntity extends Entity
{

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $lng;

    /**
     * @var float
     */
    public $lat;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'      => $this->id,
            'city_id' => $this->city_id,
            'name'    => $this->name,
            'lng'     => $this->lng,
            'lat'     => $this->lat,
        ];
    }

}