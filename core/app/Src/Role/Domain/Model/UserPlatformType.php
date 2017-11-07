<?php

namespace Huifang\Src\Role\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class UserPlatformType extends Enum
{

    const  TYPE_ANDROID = 1; //安卓客户端
    const  TYPE_IOS = 2; //IOS客户端
    const  TYPE_OTHER = 9; //其他

    /**
     * FqUserPlatformType TYPE.
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
     * Acceptable operation  model Type.
     *
     * @var array
     */
    protected static $enums = [
        self::TYPE_ANDROID => 'Android',
        self::TYPE_IOS     => 'IOS',
        self::TYPE_OTHER   => '其他',
    ];
}