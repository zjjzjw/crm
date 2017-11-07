<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class SupportType extends Enum
{
    const TYPE_ONE = 1;//完全支持（2）
    const TYPE_TWO = 2;//支持（1）
    const TYPE_THREE = 3;//中立（0）
    const TYPE_FOUR = 4;//不支持（-1）
    const TYPE_FIVE = 5;//完成不支持（-2）
    const TYPE_SIX = 6; //未知

    /**
     * SupportType TYPE.
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
        self::TYPE_ONE   => '完全支持',
        self::TYPE_TWO   => '支持',
        self::TYPE_THREE => '中立',
        self::TYPE_FOUR  => '不支持',
        self::TYPE_FIVE  => '完全不支持',
        self::TYPE_SIX   => '未知',
    ];

}