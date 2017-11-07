<?php
namespace Huifang\Src\Project\Domain\Model;

use Huifang\Src\Foundation\Domain\Enum;

class FeedBackType extends Enum
{
    const TYPE_NO = 0;//无
    const TYPE_SUCCESS = 1;//成功
    const TYPE_FAIL = 2;//失败


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
        self::TYPE_NO      => '无',
        self::TYPE_SUCCESS => '成功',
        self::TYPE_FAIL    => '失败',
    ];

}