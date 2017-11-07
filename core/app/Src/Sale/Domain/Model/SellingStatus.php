<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;


/**
 * 销售线索销售状态
 * Class SellingStatus
 * @package Huifang\Src\Sale\Domain\Model
 */
class SellingStatus extends Enum
{

    const IN_SALE = 1; //在售
    const FOR_SALE = 2; //待售
    const SOLD_OUT = 3; //售完

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
        self::IN_SALE  => '在售',
        self::FOR_SALE => '待售',
        self::SOLD_OUT => '售完',
    ];

}