<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 物业类型
 * Class ProjectScheduleType
 * @package Huifang\Src\Sale\Domain\Model
 */
class PropertyType extends Enum
{
    const ORDINARY_HOUSE = 1;
    const APARTMENT = 2;
    const VILLA = 3;
    const FOREIGN_VILLA = 4;
    const OFFICE_BUILDING = 5;
    const SHOPS = 6;
    const OTHER = 7;

    /**
     * ProjectScheduleType type.
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
        self::ORDINARY_HOUSE  => '普通住宅',
        self::APARTMENT       => '公寓',
        self::VILLA           => '别墅',
        self::FOREIGN_VILLA   => '洋房',
        self::OFFICE_BUILDING => '写字楼',
        self::SHOPS           => '商铺',
        self::OTHER           => '其他',
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