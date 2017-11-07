<?php
namespace Huifang\Src\Product\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class ProductCategoryEntity extends Entity
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
     * @var string
     */
    public $name;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'company_id' => $this->company_id,
            'name'       => $this->name,
        ];
    }
}