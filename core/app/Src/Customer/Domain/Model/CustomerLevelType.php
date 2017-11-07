<?php
namespace Huifang\Src\Customer\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class CustomerLevelType extends Enum
{
    const TYPE_A = 1;//A类
    const TYPE_B = 2;//B类
    const TYPE_C = 3;//C类
    const TYPE_D = 4;//D类

    /**
     * FuturePotentialType TYPE.
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
        self::TYPE_A => 'A类',
        self::TYPE_B => 'B类',
        self::TYPE_C => 'C类',
        self::TYPE_D => 'D类',
    ];

}