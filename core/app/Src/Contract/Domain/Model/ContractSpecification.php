<?php
namespace Huifang\Src\Contract\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class ContractSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $company_id;

    /**
     * @var array|int
     */
    public $user_ids;

    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $select_user_id;

    /**
     * @var string
     */
    public $keyword;

    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $sort;


    public function validate()
    {

    }
}