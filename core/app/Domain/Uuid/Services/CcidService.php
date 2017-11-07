<?php

namespace Huifang\Domain\Uuid\Services;

use \Cookie;

class CcidService
{
    const CCID_NAME = 'ccid';
    const DEFAULT_CITY = 1;

    /**
     * 得到城市ID
     * @return string
     */
    public static function get()
    {
        if (Cookie::get(self::CCID_NAME)) {
            return Cookie::get(self::CCID_NAME);
        }
        return self::DEFAULT_CITY;
    }

    /**
     * 设置城市ID
     * @return string
     */
    public static function set($city_id)
    {
        if (Cookie::get(self::CCID_NAME) != $city_id) {
            Cookie::queue(Cookie::forever(self::CCID_NAME, $city_id, '/', getenv('PAGE_COOKIE_DOMAIN')));
        }
    }
}
