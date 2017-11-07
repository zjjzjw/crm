<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class SwotType extends Enum
{
    const TYPE_ADVANTAGE_1 = 1;//优势一
    const TYPE_ADVANTAGE_2 = 2;//优势二
    const TYPE_ADVANTAGE_3 = 3;//优势三
    const TYPE_INFERIORITY_1 = 4;//劣势一
    CONST TYPE_INFERIORITY_2 = 5;//劣势二
    CONST TYPE_INFERIORITY_3 = 6;//劣势三

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
        self::TYPE_ADVANTAGE_1   => '我方一',
        self::TYPE_ADVANTAGE_2   => '我方二',
        self::TYPE_ADVANTAGE_3   => '我方三',
        self::TYPE_INFERIORITY_1 => '竞品一',
        self::TYPE_INFERIORITY_2 => '竞品二',
        self::TYPE_INFERIORITY_3 => '竞品三',
    ];

    protected static $scores = [
        self::TYPE_ADVANTAGE_1   => '10',
        self::TYPE_ADVANTAGE_2   => '20',
        self::TYPE_ADVANTAGE_3   => '30',
        self::TYPE_INFERIORITY_1 => '10',
        self::TYPE_INFERIORITY_2 => '20',
        self::TYPE_INFERIORITY_3 => '30',
    ];

    public function acceptableScored()
    {
        return self::$scores;
    }
}