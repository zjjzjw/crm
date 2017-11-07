<?php
namespace Huifang\Src\Role\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class DepartSpecification extends ValueObject implements Validatable
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
     * @var int
     */
    public $parent_id;

    /**
     * @var string
     */
    public $keyword;


    public function validate()
    {

    }


}