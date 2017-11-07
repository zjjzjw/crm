<?php
namespace Huifang\Src\Sale\Brand\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class BrandEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $company_name;

    /**
     * @var string
     */
    public $company_id;


    /**
     * @var string
     */
    public $brand_name;


    public function __construct()
    {
    }
    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'company_name' => $this->company_name,
            'brand_name'       => $this->brand_name,
            'company_id'       => $this->company_id,
        ];
    }
}