<?php
namespace Huifang\Src\Customer\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class BuildProjectCountType extends Enum
{
    const TYPE_FIRST = 1;//0-5
    const TYPE_SECOND = 2;//6-10
    const TYPE_THIRD = 3;//11-15
    const TYPE_FOUR = 4;//15以上


    /**
     * BuildProjectCountType TYPE.
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
        self::TYPE_FIRST  => '0-5',
        self::TYPE_SECOND => '5-10',
        self::TYPE_THIRD  => '10-15',
        self::TYPE_FOUR   => '15以上',
    ];


    protected static $limits = [
        self::TYPE_FIRST  => [null, 5],
        self::TYPE_SECOND => [5, 10],
        self::TYPE_THIRD  => [10, 15],
        self::TYPE_FOUR   => [15, null],

    ];

    public static function acceptableLimits()
    {
        return self::$limits;
    }

}