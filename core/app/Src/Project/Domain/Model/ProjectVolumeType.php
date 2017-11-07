<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 这个是用于搜索的类型
 * Class ProjectVolumeType
 * @package Huifang\Src\Project\Domain\Model
 */
class ProjectVolumeType extends Enum
{
    const  ALL = 0;
    const  VOLUME_1 = 1;
    const  VOLUME_2 = 2;
    const  VOLUME_3 = 3;
    const  VOLUME_4 = 4;

    /**
     * OperationModelType TYPE.
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
        self::ALL      => '不限',
        self::VOLUME_1 => '0-500',
        self::VOLUME_2 => '500-1000',
        self::VOLUME_3 => '1000-2000',
        self::VOLUME_4 => '2000以上',
    ];

    /**
     * limit count
     * @var array
     */
    protected static $limits = [
        self::ALL      => [null, null],
        self::VOLUME_1 => [0, 500],
        self::VOLUME_2 => [500, 1000],
        self::VOLUME_3 => [1000, 2000],
        self::VOLUME_4 => [2000, null],
    ];

    /**
     * Get all limit count
     *
     * @return array
     */
    public static function acceptableLimits()
    {
        return static::$limits;
    }

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