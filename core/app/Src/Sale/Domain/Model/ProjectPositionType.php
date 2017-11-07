<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 项目定位
 * Class ProjectPositionType
 * @package Huifang\Src\Sale\Domain\Model
 */
class ProjectPositionType extends Enum
{
    const SHALL_BE = 1;
    const STRIVE_FOR = 2;
    const RIVAL = 3;
    const DECORATION_HIGH = 4;
    const DECORATION_LOW = 5;

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
        self::SHALL_BE        => '必得项目',
        self::STRIVE_FOR      => '争取项目',
        self::RIVAL           => '竞品战略项目',
        self::DECORATION_HIGH => '装修标准过高',
        self::DECORATION_LOW  => '装修标准过低',
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