<?php namespace Xinfang\Util;

class ImageUtil
{
    const BROKER_DEFAULT_AVATR_URL = 'http://open.agjimg.com/newBroker/wode_default_avatar@2x.png';

    const INVENTORY_DEFAULT_IMAGE_URL = 'http://open.agjimg.com/non.png';

    /**
     * 获取顾问默认头像
     * @brief
     * @return
     */
    public static function getBrokerDefaultAvatr()
    {
        return self::BROKER_DEFAULT_AVATR_URL;
    }

    /**
     * 默认小区图片
     * @return string
     */
    public static function getDefaultCommunityImage()
    {
        return self::INVENTORY_DEFAULT_IMAGE_URL;
    }
}
