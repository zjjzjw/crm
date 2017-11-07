<?php

namespace Huifang\Domain\Uuid\Services;

use \Cookie;
use \Rhumsaa\Uuid\Uuid;

class UuidService
{
    const UUID_NAME = 'uuid';

    /**
     * 设置COOKIE
     * @return string
     */
    public static function get()
    {
        if (Cookie::get(self::UUID_NAME)) {
            return Cookie::get(self::UUID_NAME);
        }

        if (Cookie::queued(self::UUID_NAME)) {
            return cookie::queued(self::UUID_NAME)->getvalue();
        }

        return self::set();
    }

    /**
     * @return string
     */
    public static function set()
    {
        $uuid = (string)uuid::uuid1();
        Cookie::queue(Cookie::forever(self::UUID_NAME, $uuid, '/', getenv('PAGE_COOKIE_DOMAIN')));
        return $uuid;
    }
}
