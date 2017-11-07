<?php
namespace Huifang\Src\Contract\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class ContractPaymentType extends Enum
{
    const TYPE_PLAN = 1;//计划回款
    const TYPE_RECORD = 2;//回款记录


    /**
     * ProjectCountType TYPE.
     *
     * @var int
     */
    public $type;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'type';

    /**
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::TYPE_PLAN   => '计划回款',
        self::TYPE_RECORD => '回款记录',
    ];
}