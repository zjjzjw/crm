<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class StructureType extends Enum
{
    const TYPE_PROJECT = 1;//项目组织架构
    const TYPE_CUSTOMER = 2;//客户组织架构


    /**
     * StructureType TYPE.
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
        self::TYPE_PROJECT  => '项目组织架构',
        self::TYPE_CUSTOMER => '客户组织架构',
    ];

}