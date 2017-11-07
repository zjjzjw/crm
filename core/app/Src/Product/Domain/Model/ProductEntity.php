<?php
namespace Huifang\Src\Product\Domain\Model;

use Huifang\Src\Foundation\Domain\Entity;

class ProductEntity extends Entity
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
    public $category_id;

    /**
     * @var int
     */
    public $ascription;

    /**
     * @var int
     */
    public $ascription_id;

    /**
     * @var float
     */
    public $price;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $attribfield;

    /**
     * @var array
     */
    public $product_images;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'             => $this->id,
            'company_id'     => $this->company_id,
            'category_id'    => $this->category_id,
            'ascription'     => $this->ascription,
            'ascription_id'  => $this->ascription_id,
            'name'           => $this->name,
            'price'          => $this->price,
            'attribfield'    => $this->attribfield,
            'product_images' => $this->product_images,
        ];
    }
}