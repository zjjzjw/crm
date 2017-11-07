<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class CurrentRelatedType extends Enum
{
    const TYPE_NO = 1;//无交往（无心）
    const TYPE_KNOW = 2;//认识（1颗心)
    const TYPE_INTERACTION = 3;//互动（2颗心）
    const TYPE_FRIENDSHIP = 4;//私交（3颗心）
    const TYPE_ALLIANCE = 5;//同盟（4颗心）

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
        self::TYPE_NO          => '无交往',
        self::TYPE_KNOW        => '认识',
        self::TYPE_INTERACTION => '互动',
        self::TYPE_FRIENDSHIP  => '私交',
        self::TYPE_ALLIANCE    => '同盟',
    ];

}