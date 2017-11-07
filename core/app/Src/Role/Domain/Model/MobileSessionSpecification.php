<?php
namespace Huifang\Src\Role\Domain\Model;

use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class MobileSessionSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var string
     */
    public $keyword;

    public function __construct()
    {

    }

    public function validate()
    {

    }

}