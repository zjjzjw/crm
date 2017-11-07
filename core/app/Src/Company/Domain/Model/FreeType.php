<?php namespace Huifang\Src\Company\Domain\Model;


use Huifang\Src\Foundation\Domain\Enum;

class FreeType extends Enum
{
    const FREE_YES = 1;
    const FREE_NOT = 2;

    /**
     * loan type.
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
        self::FREE_YES => '是',
        self::FREE_NOT => '否',
    ];


}