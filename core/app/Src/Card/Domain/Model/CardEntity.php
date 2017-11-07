<?php
namespace Huifang\Src\Card\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\Entity;

class CardEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $initials;

    /**
     * @var string
     */
    public $full_pinyin;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $tel;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $position_name;

    /**
     * @var string
     */
    public $company_name;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $zip_code;

    public function __construct()
    {

    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'            => $this->id,
            'company_id'    => $this->company_id,
            'user_id'       => $this->user_id,
            'name'          => $this->name,
            'initials'      => $this->initials,
            'full_pinyin'   => $this->full_pinyin,
            'phone'         => $this->phone,
            'tel'           => $this->tel,
            'email'         => $this->email,
            'position_name' => $this->position_name,
            'company_name'  => $this->company_name,
            'address'       => $this->address,
            'zip_code'      => $this->zip_code,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }

}