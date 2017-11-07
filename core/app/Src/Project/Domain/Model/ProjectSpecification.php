<?php
namespace Huifang\Src\Project\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class ProjectSpecification extends ValueObject implements Validatable
{

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var Carbon
     */
    public $start_time;

    /**
     * @var Carbon
     */
    public $end_time;

    /**
     * @var int
     */
    public $project_volume_min;

    /**
     * @var int
     */
    public $project_volume_max;

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
     * @var int
     */
    public $project_volume_type;

    /**
     * @var string
     */
    public $keyword;

    /**
     * @var array
     */
    public $project_ids;

    public function validate()
    {

    }
}