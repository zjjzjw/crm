<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class AnalyseType extends Enum
{
    const TYPE_RELATION = 1;//客户关系
    const TYPE_PRODUCT = 2;//产品
    const TYPE_PRICE = 3;//价格
    const TYPE_COMPETE = 4;//服务
    const TYPE_BRAND = 5;//品牌
    const TYPE_OTHER = 6;//其他

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
        self::TYPE_RELATION => '客户关系',
        self::TYPE_PRODUCT  => '产品',
        self::TYPE_PRICE    => '价格',
        self::TYPE_COMPETE  => '服务',
        self::TYPE_BRAND    => '品牌',
        self::TYPE_OTHER    => '其他',
    ];

}