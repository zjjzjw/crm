<?php
namespace Huifang\Src\Contract\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class ContractEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $company_id;
    /**
     * @var string
     */
    public $contract_number;

    /**
     * @var string
     */
    public $contract_name;

    /**
     * @var int
     */
    public $customer_id;

    /**
     * @var string
     */
    public $customer_name;

    /**
     * @var int
     */
    public $product_id;

    /**
     * @var int
     */
    public $product_number;

    /**
     * @var float
     */
    public $product_price;

    /**
     * @var float
     */
    public $contract_amount;

    /**
     * @var float
     */
    public $down_payment;

    /**
     * @var Carbon
     */
    public $expected_return_at;

    /**
     * @var float
     */
    public $tail_amount;

    /**
     * @var Carbon
     */
    public $tail_amount_at;

    /**
     * @var Carbon
     */
    public $product_delivery_at;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var Carbon
     */
    public $signed_at;

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
            'id'                  => $this->id,
            'user_id'             => $this->user_id,
            'company_id'          => $this->company_id,
            'contract_number'     => $this->contract_number,
            'contract_name'       => $this->contract_name,
            'signed_at'           => $this->signed_at->toDateTimeString(),
            'customer_id'         => $this->customer_id,
            'customer_name'       => $this->customer_name,
            'product_id'          => $this->product_id,
            'product_number'      => $this->product_number,
            'product_price'       => $this->product_price,
            'contract_amount'     => $this->contract_amount,
            'down_payment'        => $this->down_payment,
            'expected_return_at'  => $this->expected_return_at->toDateTimeString(),
            'tail_amount'         => $this->tail_amount,
            'tail_amount_at'      => $this->tail_amount_at->toDateTimeString(),
            'product_delivery_at' => $this->product_delivery_at->toDateTimeString(),
            'created_user_id'     => $this->created_user_id,
            'products'            => $this->products,
            'created_at'          => $this->created_at->toDateTimeString(),
            'updated_at'          => $this->updated_at->toDateTimeString(),
        ];
    }

}