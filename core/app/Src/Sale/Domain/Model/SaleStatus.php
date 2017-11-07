<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;


/**
 * 销售线索分配状态
 * Class SaleStatus
 * @package Huifang\Src\Sale\Domain\Model
 */
class SaleStatus extends Enum
{

    const UN_KNOW = 0;//未知状态
    const TO_ASSIGN = 1; //待认领
    const ASSIGNING = 2; //分配中
    const ASSIGNED = 3; //已分配

    /**
     * MsgStatus status.
     *
     * @var string
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::TO_ASSIGN => '待分配',
        self::ASSIGNING => '分配中',
        self::ASSIGNED  => '已分配',
    ];


    protected static $audit_enums = [
        self::TO_ASSIGN => '待认领',
        self::ASSIGNING => '待审核',
        self::ASSIGNED  => '审核通过',
    ];

    public static function acceptableAuditEnums()
    {
        return static::$audit_enums;
    }


}