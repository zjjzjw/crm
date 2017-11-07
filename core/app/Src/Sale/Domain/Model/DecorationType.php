<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 装修类型
 * Class DecorationType
 * @package Huifang\Src\Sale\Domain\Model
 */
class DecorationType extends Enum
{
    const ROUGH = 1;
    const HARDCOVER = 2;
    const PART_HARDCOVER = 3;
    const MENU_OPTIONAL = 4;
    const UNDETERMINED = 5;

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
        self::ROUGH          => '毛坯',
        self::HARDCOVER      => '精装',
        self::PART_HARDCOVER => '部分精装',
        self::MENU_OPTIONAL  => '菜单式/选装',
        self::UNDETERMINED   => '未确定',
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