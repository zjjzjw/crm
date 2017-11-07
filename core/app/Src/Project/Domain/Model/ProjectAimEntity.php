<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ProjectAimEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $project_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $product_ids;

    /**
     * @var float
     */
    public $price;

    /**
     * @var int
     */
    public $volume;

    /**
     * @var string
     */
    public $pain_analysis;

    /**
     * @var string
     */
    public $other;

    /**
     * @var array
     */
    public $products;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'            => $this->id,
            'project_id'    => $this->project_id,
            'name'          => $this->name,
            'product_ids'   => $this->product_ids,
            'price'         => $this->price,
            'volume'        => $this->volume,
            'pain_analysis' => $this->pain_analysis,
            'other'         => $this->other,
            'products'      => $this->products,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}