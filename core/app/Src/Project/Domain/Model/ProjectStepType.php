<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class ProjectStepType extends Enum
{
    const  EARLIER = 1;
    const  MIDDLE = 2;
    const  LATER = 3;


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

        self::EARLIER => '主体施工前期',
        self::MIDDLE  => '主体施工中期',
        self::LATER   => '主体施工后期',
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