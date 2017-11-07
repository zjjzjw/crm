<?php
namespace Huifang\Src\Sale\LargeArea\Domain\Model;

use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class LargeAreaSpecification extends ValueObject implements Validatable
{

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