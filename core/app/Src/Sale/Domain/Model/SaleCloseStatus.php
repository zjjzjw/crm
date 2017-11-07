<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 销售线索关闭状态
 * Class SaleCloseStatus
 * @package Huifang\Src\Sale\Domain\Model
 */
class SaleCloseStatus extends Enum
{
    const CERTIFIED_GOODS = 1;//已定竞品
    const COMPETITIVE_STRATEGY = 2;//竞品战略
    const LOW_BUDGET = 3;//预算过低
    const NOT_MATCH = 4;//产品标准不符
    const DISADVANTAGE = 5;//客户关系劣势
    const OTHER = 6;//其他

    /**
     * MsgStatus status.
     *
     * @var string
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::CERTIFIED_GOODS      => '已定竞品',
        self::COMPETITIVE_STRATEGY => '竞品战略',
        self::LOW_BUDGET           => '预算过低',
        self::NOT_MATCH            => '产品标准不符',
        self::DISADVANTAGE         => '客户关系劣势',
        self::OTHER                => '其他',
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