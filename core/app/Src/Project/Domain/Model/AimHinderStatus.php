<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class AimHinderStatus extends Enum
{
    const STATUS_INIT = 1;//待审核
    const STATUS_PASS = 2;//审核通过
    const STATUS_REJECT = 3;//审核驳回


    /**
     * AimHinderStatus STATUS.
     *
     * @var int
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::STATUS_INIT   => '待审核',
        self::STATUS_PASS   => '审核通过',
        self::STATUS_REJECT => '审核驳回',
    ];

}