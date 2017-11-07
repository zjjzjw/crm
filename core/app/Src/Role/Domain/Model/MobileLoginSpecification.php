<?php
namespace Huifang\Src\Role\Domain\Model;

use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class MobileLoginSpecification extends ValueObject implements Validatable
{
    /**
     * @var string
     */
    public $account;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $reg_id;

    /**
     * @var string
     */
    public $ip;


    public function __construct()
    {

    }

    public function validate()
    {

    }

}