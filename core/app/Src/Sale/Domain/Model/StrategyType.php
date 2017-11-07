<?php namespace Huifang\Src\Sale\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

/**
 * 战略归属
 * Class StrategyType
 * @package Huifang\Src\Sale\Domain\Model
 */
class StrategyType extends Enum
{
    const FOTILE = 1;
    const RIVAL = 2;
    const NO = 3;

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
        self::FOTILE => '方太战略',
        self::RIVAL  => '竞品战略',
        self::NO     => '无战略',
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