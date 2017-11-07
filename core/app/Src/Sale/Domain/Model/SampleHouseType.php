<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 *
 * Class SampleHouseType
 * @package Huifang\Src\Sale\Domain\Model
 */
class SampleHouseType extends Enum
{
    const YES = 1;
    const NO = 2;


    /**
     * DecorationType type.
     *
     * @var string
     */
    public $type;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'type';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::YES => '有',
        self::NO  => '无',
    ];

    /**
     * @return array
     */
    public static function acceptableList()
    {
        $items = [];
        foreach (self::$enums as $key => $name) {
            $item['id'] = $key;
            $item['name'] = $name;
            $items[] = $item;
        }
        return $items;
    }

}