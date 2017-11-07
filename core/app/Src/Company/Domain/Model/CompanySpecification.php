<?php
namespace Huifang\Src\Company\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class CompanySpecification extends ValueObject implements Validatable
{

    public $page;
    /**
     * @var Carbon
     */
    public $start_time;

    /**
     * @var Carbon
     */
    public $end_time;

    /**
     * @var string
     */
    public $keyword;


    public function validate()
    {

    }


}