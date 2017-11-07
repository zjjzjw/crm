<?php
namespace Huifang\Domain\BizConfig\Data;

class BizConfigData
{
    /**
     * 获取业务配置信息
     * @return array 业务配置信息
     */
    public function getConfigData()
    {
        if (getenv('APP_ENV') == 'production') {//线上
            return [
                'buyer_go_public_time'        => 15,//超过多少天踢公
                'buyer_max'                   => 200,//私客上限
                'broker_is_invalid'           => 7 * 86400, //顾问离职7天/秒
                'temporary_broker_is_invalid' => 7 * 86400, //临时的顾问离职展示时间
                'recommend_district_ids'      => [           //推荐区域房源
                    7, 11, 9, 13, 15, 4, 2, 14, 19, 17, 18, 20, 7049,
                ],
                'novisit_days_cancel_alevel'  => 14,//多少天未到访取消A客
                'standard_new_buyer'          => 20,//新增私客数20
                'standard_new_a_client'       => 5,//新增A客数5
                'standard_new_visited'        => 3,//新增到访数3
            ];
        } else {//线下
            return [
                'buyer_go_public_time'        => 15,//超过多少天踢公
                'buyer_max'                   => 20,//私客上限
                'broker_is_invalid'           => 30 * 60, //顾问离职 30分/秒
                'temporary_broker_is_invalid' => 7 * 86400, //临时的顾问离职展示时间
                'recommend_district_ids'      => [
                    7, 11, 9, 13, 15, 4, 2, 14, 19, 17, 18, 20, 7049,
                ],
                'novisit_days_cancel_alevel'  => 1,//多少天未到访取消A客
                'standard_new_buyer'          => 2,//新增私客数2
                'standard_new_a_client'       => 1,//新增A客数1
                'standard_new_visited'        => 1,//新增到访数1
            ];
        }
    }
}
