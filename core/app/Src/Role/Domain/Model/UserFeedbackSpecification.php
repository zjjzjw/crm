<?php
namespace Huifang\Src\Role\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class UserFeedbackSpecification extends ValueObject implements Validatable
{

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

    /**
     * @var int
     */
    public $page;


    public function validate()
    {

    }


}