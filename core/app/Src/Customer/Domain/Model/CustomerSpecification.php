<?php
namespace Huifang\Src\Customer\Domain\Model;

use Carbon\Carbon;
use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class CustomerSpecification extends ValueObject implements Validatable
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
     * @var int
     */
    public $project_count_min;

    /**
     * @var int
     */
    public $project_count_max;

    /**
     * @var int
     */
    public $project_count_type;

    /**
     * @var int
     */
    public $build_project_count_min;

    /**
     * @var int
     */
    public $build_project_count_max;

    /**
     * @var int
     */
    public $build_project_count_type;

    /**
     * @var int
     */
    public $future_potential_min;

    /**
     * @var int
     */
    public $future_potential_max;

    /**
     * @var int
     */
    public $future_potential_type;

    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $sort;

    /**
     * @var int
     */
    public $level;


    public function validate()
    {

    }
}