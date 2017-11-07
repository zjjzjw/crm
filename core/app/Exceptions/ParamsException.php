<?php namespace Huifang\Exceptions;


class ParamsException extends BaseException
{

    const ERROR_PARAMS = 2000;

    /*
     * 异常和 HTTP Status Code 映射
     *
     * @var array
     */
    protected $http_status_codes = [
        self::ERROR_PARAMS => '401',
    ];

    /**
     * 异常和文案映射
     *
     * @var array
     */
    protected $pretty_messages = [
        self::ERROR_PARAMS => '参数错误',
    ];
}

