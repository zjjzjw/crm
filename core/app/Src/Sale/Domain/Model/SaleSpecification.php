<?php
namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\ValueObject;
use Huifang\Src\Foundation\Support\Interfaces\Validatable;

class SaleSpecification extends ValueObject implements Validatable
{
    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var int
     */
    public $company_id;

    /**
     * @var int
     */
    public $project_volume_min;

    /**
     * @var int
     */
    public $project_volume_max;

    /**
     * @var int
     */
    public $project_step_type;

    /**
     * 数据权限
     * @var array|int
     */
    public $user_ids;

    /**
     * @var int
     */
    public $page;

    /**
     * 自己相关
     * @var int
     */
    public $user_id;

    /**
     * 过滤筛选的用户家ID
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

    /**
     * @var int|array
     */
    public $close_status;


    public function validate()
    {

    }
}