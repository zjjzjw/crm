<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class ProjectAimHinderSpecification extends ValueObject implements Validatable
{

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
     * @var array
     */
    public $project_ids;

    /**
     * @var int|array
     */
    public $status;

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