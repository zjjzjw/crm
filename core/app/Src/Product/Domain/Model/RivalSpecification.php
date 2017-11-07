<?php
namespace Huifang\Src\Product\Domain\Model;

use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class RivalSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $company_id;

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