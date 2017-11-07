<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 工程进度类型
 * Class ProjectScheduleType
 * @package Huifang\Src\Sale\Domain\Model
 */
class ProjectScheduleType extends Enum
{
    const IN_PLANNING = 1;
    const UNDER_CONSTRUCTION = 2;
    const CAPPED = 3;
    const COMPLETED = 4;
    const HAND_OVER = 5;
    const UNDETERMINED = 6;

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
        self::IN_PLANNING        => '规划中',
        self::UNDER_CONSTRUCTION => '在建中',
        self::CAPPED             => '已封顶',
        self::COMPLETED          => '已竣工',
        self::HAND_OVER          => '已交房',
        self::UNDETERMINED       => '未确定',
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