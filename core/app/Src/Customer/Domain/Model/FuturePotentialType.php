<?php
namespace Huifang\Src\Customer\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class FuturePotentialType extends Enum
{
    const TYPE_FIRST = 1;//0-500
    const TYPE_SECOND = 2;//500-1000
    const TYPE_THIRD = 3;//1000-2000
    const TYPE_FOUR = 4;//2000以上

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
        self::TYPE_FIRST  => '0-500',
        self::TYPE_SECOND => '500-1000',
        self::TYPE_THIRD  => '1000-2000',
        self::TYPE_FOUR   => '2000以上',
    ];


    protected static $limits = [
        self::TYPE_FIRST  => [null, 500],
        self::TYPE_SECOND => [500, 1000],
        self::TYPE_THIRD  => [1000, 2000],
        self::TYPE_FOUR   => [2000, null],

    ];

    public static function acceptableLimits()
    {
        return self::$limits;
    }

}