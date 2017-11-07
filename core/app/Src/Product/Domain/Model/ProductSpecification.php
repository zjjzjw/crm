<?php
namespace Huifang\Src\Product\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class ProductSpecification extends ValueObject implements Validatable
{
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
    public $page;

    /**
     * @var int
     */
    public $ascription;

    /**
     * @var int
     */
    public $ascription_id;

    /**
     * @var string
     */
    public $keyword;


    public function validate()
    {

    }

}