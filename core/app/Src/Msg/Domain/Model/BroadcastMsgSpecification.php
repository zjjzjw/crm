<?php
namespace Huifang\Src\Msg\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class BroadcastMsgSpecification extends ValueObject implements Validatable
{
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