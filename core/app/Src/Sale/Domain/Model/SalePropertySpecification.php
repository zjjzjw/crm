<?php
namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class SalePropertySpecification extends ValueObject implements Validatable
{


    /**
     * @var int
     */
    public $page;

    /**
     * @var string
     */
    public $keyword;


    public function validate()
    {

    }
}