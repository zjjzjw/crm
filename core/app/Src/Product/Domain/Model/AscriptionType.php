<?php
namespace Huifang\Src\Product\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class AscriptionType extends Enum
{
    const TYPE_RIVAL = 1;//竞品公司
    const TYPE_OWNER = 2;//本公司


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
        self::TYPE_RIVAL => '竞品公司',
        self::TYPE_OWNER => '本公司',
    ];

}