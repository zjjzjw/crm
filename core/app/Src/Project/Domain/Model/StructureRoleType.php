<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class StructureRoleType extends Enum
{
    const KEY_PERSON = 1;//关键人（红色）
    const STAKEHOLDER = 2;//干系人（蓝色）
    const NON_STAKEHOLDER = 3;//非干系人（灰色）


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
        self::KEY_PERSON      => '关键人',
        self::STAKEHOLDER     => '干系人',
        self::NON_STAKEHOLDER => '非干系人',
    ];

}