<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class CharacterType extends Enum
{
    const TYPE_ONE = 1;//改革者
    const TYPE_TWO = 2;//帮助者
    const TYPE_THREE = 3;//促动者
    const TYPE_FOUR = 4;//艺术家
    const TYPE_FIVE = 5;//思想家
    const TYPE_SIX = 6;//忠诚者
    const TYPE_SEVEN = 7;//多面手
    const TYPE_EIGHT = 8;//指导者
    const TYPE_NINE = 9;//和事佬


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

        self::TYPE_ONE   => '改革者',
        self::TYPE_TWO   => '帮助者',
        self::TYPE_THREE => '促动者',
        self::TYPE_FOUR  => '艺术家',
        self::TYPE_FIVE  => '思想家',
        self::TYPE_SIX   => '忠诚者',
        self::TYPE_SEVEN => '多面手',
        self::TYPE_EIGHT => '指导者',
        self::TYPE_NINE  => '和事佬',

    ];

}