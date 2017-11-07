<?php
namespace Huifang\Src\Contract\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class ContractPaymentStatus extends Enum
{
    const PROGRESS = 1;//进行中
    const FINISH = 2;//已完成


    /**
     * ProjectCountStatus status.
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
        self::PROGRESS => '进行中',
        self::FINISH   => '已完成',
    ];
}