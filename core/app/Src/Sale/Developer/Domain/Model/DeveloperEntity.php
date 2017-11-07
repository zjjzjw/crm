<?php
namespace Huifang\Src\Sale\Developer\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class DeveloperEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;
    /**
     * @var string
     */
    public $name;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'company_id'  => $this->company_id,
            'province_id' => $this->province_id,
            'city_id'     => $this->city_id,
            'name'        => $this->name,
        ];
    }
}