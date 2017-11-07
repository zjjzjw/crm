<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;


/**
 * 项目签约状态
 * Class SellingStatus
 * @package Huifang\Src\Sale\Domain\Model
 */
class ProjectEstimateStatus extends Enum
{

    const YES = 1;
    const NO = 2;

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
        self::YES  => '已签',
        self::NO => '未签',
    ];

}