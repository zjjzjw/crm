<?php

namespace Huifang\Web\Application\Touch;

use Xinfang\Domains\Basic\BasicService;
use Xinfang\Domains\Basic\BlockService;
use Xinfang\Domains\Basic\CallService;
use Xinfang\Domains\Basic\DistrictService;
use Xinfang\Domains\Basic\TouchUrlService;
use Xinfang\Domains\BizConfig\Data\BizConfigData;
use Xinfang\Domains\Loupan\Entities\LoupanBasicEntity;
use Xinfang\Domains\Loupan\Services\HouseTypeService;
use Xinfang\Domains\Loupan\Services\LoupanListService;
use Xinfang\Domains\Loupan\Services\LoupanService;
use Xinfang\Service\Config\AppConfigService;
use \Cache;

class TouchShowService
{

    /**
     * 根据区域条件查询
     * @param $params
     * @return array
     */
    public function selectDistrictByWhere($params)
    {
        /** @var $district_service \Xinfang\Domains\Basic\DistrictService */
        $district_service = app(DistrictService::class);
        return $district_service->selectByWhere($params);
    }

    /**
     * 根据板块条件查询
     * @param $params
     * @return array
     */
    public function selectBlockByWhere($params)
    {
        /** @var $block_service \Xinfang\Domains\Basic\BlockService */
        $block_service = app(BlockService::class);
        return $block_service->selectByWhere($params);
    }

    /**
     * 根据条件组合数据
     * @param $params
     * @return array
     */
    public function selectDistrictAndBlock($params)
    {
        $cache_key = 'touch|' . __METHOD__ . '|cityid' . md5(json_encode($params));
        $result = Cache::get($cache_key);
        if (empty($data['district_and_block'])) {
            $district_result = $this->selectDistrictByWhere($params);
            $block_result = $this->selectBlockByWhere($params);
            $result = [];
            foreach ($district_result as $district) {
                $tmp = [
                    'id'      => $district->id,
                    'name'    => $district->name,
                    'quanpin' => $district->quanpin,
                ];
                foreach ($block_result as $block) {
                    if ($block->district_id == $district->id) {
                        $tmp['block'][] = [
                            'id'      => $block->id,
                            'name'    => $block->name,
                            'quanpin' => $block->quanpin,
                        ];
                    }
                }
                $result[] = $tmp;
            }
            \Cache::put($cache_key, $result, 60);
        }
        return $result;
    }

    /**
     * 根据城市条件搜索新房列表
     * @param $params
     * @param $city_id
     * @return array
     */
    public function showList($params, $city_id)
    {
        if (isset($params['per_page'])) {
            $params['limit'] = $params['per_page'];
        } else {
            $params['limit'] = 10;
        }
        if (isset($params['page'])) {
            $params['offset'] = $params['page'] - 1 < 0 ? 0 : ($params['page'] - 1) * $params['limit'];
        }
        if (isset($params['min_price']) && isset($params['max_price'])) {
            $params['is_select_house_type'] = true;
            $params['price'] = [$params['min_price'], $params['max_price']];
            unset($params['min_price']);
            unset($params['max_price']);
        }
        if (isset($params['min_bedrooms']) && isset($params['max_bedrooms'])) {
            $params['is_select_house_type'] = true;
            $params['min_bedroom'] = $params['min_bedrooms'];
            $params['max_bedroom'] = $params['max_bedrooms'];
            unset($params['min_bedrooms']);
            unset($params['min_bedrooms']);
        }
        if (!empty($params['property_type'])) {
            $params['is_show_basic_id'] = true;
            /** @var $app_config_service \Xinfang\Service\Config\AppConfigService */
            $app_config_service = AppConfigService::getInstance();
            $property_type = $app_config_service->getConfig('property_type');
            $params['property_keyword'] = $property_type[$params['property_type']]['name'] ?? '';
        }
        //初始化默认值
        $list = [
            'items' => [],
            'pager' => [
                'total'        => 0,
                'current_page' => 1,
                'per_page'     => $params['limit'],
                'last_page'    => 1,
            ],
        ];
        /** @var $loupan_list_service \Xinfang\Domains\Loupan\Services\LoupanListService */
        $loupan_list_service = app(LoupanListService::class);
        $result = $loupan_list_service->selectLoupanListByParams($params, $city_id);

        //生成URL
        /** @var $touch_url_service \Xinfang\Domains\Basic\TouchUrlService */
        $touch_url_service = app(TouchUrlService::class);
        foreach ($result['items'] as &$item) {
            $item['url'] = $touch_url_service->newHouseTouchDetail($item['city_id'], $item['id']);
        }

        $list['items'] = $result['items'];

        $last_page = ceil($result['total'] / $params['limit']);

        $list['pager'] = [
            'total'        => $result['total'],
            'current_page' => $params['page'] ?? 1,
            'per_page'     => $params['limit'],
            'last_page'    => ($params['page'] ?? 1) + 1 <= $last_page ? ($params['page'] ?? 1) + 1 : $last_page,
        ];
        return $list;
    }

    /**
     * 根据关键词搜索
     * @param $keyword
     * @param $city_id
     * @return array
     */
    public function showSearch($keyword, $city_id)
    {
        if (empty($keyword)) {
            return [];
        }
        /** @var $loupan_service \Xinfang\Domains\Loupan\Services\LoupanService */
        $loupan_service = app(LoupanService::class);
        return $loupan_service->showLoupanKeyWordSearch($keyword, $city_id);
    }

    /**
     * 展示TOUCH端的配置
     * @param $city_id
     * @return array
     */
    public function showAppConfig($city_id)
    {
        /** @var $touch_url_service \Xinfang\Domains\Basic\TouchUrlService */
        $touch_url_service = app(TouchUrlService::class);

        $district_and_block = $this->selectDistrictAndBlock(['city_id' => $city_id]);

        $data['district_list'] = [];
        $data['district_block_list'] = [];
        foreach ($district_and_block as $district_and_block_v) {
            $data['district_list'][] = [
                'id'   => $district_and_block_v['id'],
                'name' => $district_and_block_v['name'],
                'url'  => $touch_url_service->newHouseBasicTouchList($city_id, $district_and_block_v['quanpin']),
            ];
            $blocks = $district_and_block_v['block'] ?? [];
            foreach ($blocks as $block) {
                $data['district_block_list'][$district_and_block_v['id']][] = [
                    'id'   => $block['id'],
                    'name' => $block['name'],
                    'url'  => $touch_url_service->newHouseBasicTouchList($city_id, $district_and_block_v['quanpin'], $block['quanpin']),
                ];
            }
        }

        /** @var $app_config_service \Xinfang\Service\Config\AppConfigService */
        $app_config_service = AppConfigService::getInstance();
        $data['unit_price'] = $app_config_service->getConfig('unit_price_for_tw');
        $data['property_type'] = $app_config_service->getConfig('property_type');
        $data['room_type'] = $app_config_service->getConfig('room_type');

        /** @var $biz_config_data \Xinfang\Domains\BizConfig\Data\BizConfigData */
        $biz_config_data = app(BizConfigData::class);
        $district_result = $this->selectDistrictByWhere(['id' => implode(';', $biz_config_data->getConfigData()['recommend_district_ids']), 'city_id' => $city_id]);

        foreach ($district_result as $district) {
            $data['recommend_district'][] = [
                'id'   => $district->id,
                'name' => $district->name,
                'url'  => $touch_url_service->newHouseBasicTouchList($city_id, $district->quanpin),
            ];
        }

        return $data;
    }

    /**
     * 展示楼盘详情页
     * @param      $loupan_id
     * @param null $by
     * @return array
     */
    public function showLoupan($loupan_id, $by = null)
    {
        /** @var $loupan_service \Xinfang\Domains\Loupan\Services\LoupanService */
        $loupan_service = app(LoupanService::class);
        $loupan = $loupan_service->getLoupanTwShowByLoupanId($loupan_id, $by);
        /** @var $basic_service \Xinfang\Domains\Basic\BasicService */
        $basic_service = app(BasicService::class);
        $cities = $basic_service->getAllCity();
        /** @var $touch_url_service \Xinfang\Domains\Basic\TouchUrlService */
        $touch_url_service = app(TouchUrlService::class);
        if (!empty($loupan['hot_loupans'])) {
            foreach ($loupan['hot_loupans'] as &$item) {
                $item['url'] = $touch_url_service->newHouseTouchDetail($item['city_id'], $item['loupan_id']);
            }
        }
        if (!empty($loupan['house_type'])) {
            foreach ($loupan['house_type'] as &$bedroom) {
                $bedroom['url'] = $touch_url_service->newHouseTouchBedroomDetail($bedroom['id']);
            }
        }
        $result = [
            'is_partner'     => $loupan['basic']->getPartnerStatus() == LoupanBasicEntity::PARTNER_STATUS_YES,
            'loupan_id'      => $loupan['basic']->getId(),
            'city_id'        => $loupan['basic']->getCityId(),
            'title'          => $this->hiddenTitlePhone($loupan['basic']->getLoupanName()),
            'address'        => empty($loupan['basic']->getAddress()) ? '--' : $this->hiddenTitlePhone($loupan['basic']->getAddress()),
            'district'       => empty($loupan['district']) ? '--' : $loupan['district'],
            'district_id'    => $loupan['district_id'] ?? 0,
            'block_id'       => $loupan['block_id'] ?? 0,
            'loop_line'      => empty($loupan['basic']->getLoopLine()) ? '--' : $loupan['basic']->getLoopLine(),
            'unit_price'     => $loupan['basic']->getUnitPrice(),
            'area'           => $loupan['area'],
            'dynamic'        => $loupan['dynamic'] ?? [],
            'discount_desc'  => $loupan['discount']->getContent(),
            'selling_date'   => $loupan['basic']->getSellingDate() == '0000-00-00' ? "待定" : $loupan['basic']->getSellingDate(),
            'handover_date'  => $loupan['basic']->getHandoverDate() == '0000-00-00' ? "待定" : $loupan['basic']->getHandoverDate(),
            'property_type'  => empty($loupan['extend']->getPropertyType()) ? '--' : $loupan['extend']->getPropertyType(),
            'fitment_type'   => empty($loupan['extend']->getFitmentType()) ? '--' : $loupan['extend']->getFitmentType(),
            'builder'        => empty($loupan['extend']->getBuilder()) ? '--' : $loupan['extend']->getBuilder(),
            'property_right' => empty($loupan['extend']->getYears()) ? '--' : $loupan['extend']->getYears() . '年',
            'manager'        => empty($loupan['extend']->getManager()) ? '--' : $loupan['extend']->getManager(),
            'building_type'  => empty($loupan['extend']->getBuildingType()) ? '--' : $loupan['extend']->getBuildingType(),
            'house_plan'     => empty($loupan['extend']->getHousePlan()) ? '--' : $loupan['extend']->getHousePlan(),
            'car_rate'       => empty($loupan['extend']->getCarbarnState() && $loupan['extend']->getHousePlan()) ? '--' : '1:' . round($loupan['extend']->getCarbarnState() / $loupan['extend']->getHousePlan(), 2),
            'contain_rate'   => empty($loupan['extend']->getContainRate()) ? '--' : $loupan['extend']->getContainRate(),
            'green_pert'     => empty($loupan['extend']->getGreenRate()) ? '--' : $loupan['extend']->getGreenRate() . '%',
            'house_status'   => $loupan['basic']->getSaleStatusDesc(),
            'lng'            => $loupan['extend']->getLng(),
            'lat'            => $loupan['extend']->getLat(),
            'nearby_line'    => $loupan['nearby_line'],
            'house_types'    => $loupan['house_type'],
            'loupan_images'  => $loupan['image'],
            'sale'           => [
                'show_phone' => $loupan['phone']['show_phone'],
                'call_phone' => $loupan['phone']['call_phone'],
                'desc'       => '最新政策,更多优惠详情,请致电售楼处',
            ],
            'hot_loupans'    => $loupan['hot_loupans'],
            'city_name'      => $cities[$loupan['basic']->getCityId()]->name ?? '上海',
        ];
        return $result;
    }

    /**
     * 过滤标题里的特殊文案
     * @param $title
     * @return mixed
     */
    public static function hiddenTitlePhone($title)
    {
        $title = preg_replace('/最/', '*', $title);
        $title = preg_replace('/极佳/', '好', $title);
        $title = preg_replace('/\<.*?\>/i', '', $title);
        $title = preg_replace('/学区/', '*区', $title);

        return preg_replace('#(\d{3})\d{5}(\d{3})#', '${1}*****${2}', $title);
    }

    /**
     * 根据户型id展示户型单页
     * @param      $bedroom_id
     * @param null $by
     * @return array
     */
    public function showBedroom($bedroom_id, $by = null)
    {
        $result = [];
        /** @var $house_type_service \Xinfang\Domains\Loupan\Services\HouseTypeService */
        $house_type_service = app(HouseTypeService::class);
        $house_type = $house_type_service->getHouseByHouseTypeId($bedroom_id) ?? '';
        $result['name'] = $house_type['basic']->getName() ?? '';
        $result['living_room'] = $house_type['basic']->getLivings() ?? '';
        $result['loupan_id'] = $house_type['basic']->getLoupanId() ?? '';
        $result['bathrooms'] = $house_type['basic']->getToilets() ?? '';
        $result['bedrooms'] = $house_type['basic']->getRooms() ?? '';
        $result['area'] = empty($house_type['basic']->getArea()) ? '' : $house_type['basic']->getArea() . 'm²';
        $result['orientation'] = empty($house_type['basic']->getOrient(true))
            ? '' : $house_type['basic']->getOrient(true);
        $result['price'] = empty($house_type['basic']->getHousePrice()) ? '待定' : '约' . round($house_type['basic']->getHousePrice() / 10000, 2) . '万元';
        $result['analysis'] = $house_type['extend']->getAnalysis();
        $result['images'] = [];
        if (!empty($house_type['image'])) {
            foreach ($house_type['image'] as $key => $image) {
                $result['images'][] = [
                    'id'  => $key,
                    'url' => $image,
                ];
            }
        }

        $result['tags'] = $house_type['tags'];
        /** @var $call_service \Xinfang\Domains\Basic\CallService */
        $call_service = app(CallService::class);
        $loupan_phone = !empty($by) ? $call_service->getBrokerShortNum($by) : $call_service->getLoupanShortNum($house_type['basic']->getLoupanId());

        if (!empty($loupan_phone)) {
            $big_num = substr($loupan_phone->main_number, 0, 3) . ' ' . substr($loupan_phone->main_number, 3, 4) . ' ' . substr($loupan_phone->main_number, 7);
            $show_phone = $big_num . '转' . $loupan_phone->tw_short_num;
            $call_phone = $loupan_phone->main_number . ',' . $loupan_phone->tw_short_num;
        }

        $result['phone'] = [
            'show_phone' => $show_phone ?? '',
            'call_phone' => $call_phone ?? '',
        ];

        return $result;
    }

    /**
     * 展示地图相关信息
     * @param $id
     * @return array
     */
    public function showMap($id)
    {
        /** @var $loupan_service \Xinfang\Domains\Loupan\Services\LoupanService */
        $loupan_service = app(LoupanService::class);
        $loupan = $loupan_service->getLoupanBasic($id);
        $result = [
            'loupan_id' => $loupan['basic']->getId(),
            'address'   => empty($loupan['basic']->getAddress()) ? "--" : $loupan['basic']->getAddress(),
            'lng'       => $loupan['extend']->getLng(),
            'lat'       => $loupan['extend']->getLat(),
            'bmap_ak'   => getenv('BAIDU_MAP_AK'),
        ];
        return $result;
    }


    public function getLoupanDetailSeo($city_name, $district_name, $block_name, $loupan_name)
    {
        $str = '';
        if (!empty($city_name)) {
            $str = $city_name;
        }
        if (!empty($district_name)) {
            $str .= '/' . $district_name;
        }
        if (!empty($block_name)) {
            $str .= '/' . $block_name;
        }

        $title = "{$str}楼盘网，";
        $title .= "{$str}新房一手房，";
        $title .= "{$str}房产网信息网，最新开盘在售{$str}楼盘信息-{$loupan_name}-安个家";

        $keyword = $title;
        $description = $title;

        return compact('title', 'keyword', 'description');
    }

    public function getLoupanListSeo($city_name, $district_name, $block_name)
    {
        $str = '';
        if (!empty($city_name)) {
            $str = $city_name;
        }
        if (!empty($district_name)) {
            $str .= '/' . $district_name;
        }
        if (!empty($block_name)) {
            $str .= '/' . $block_name;
        }

        $title = "{$str}楼盘网，";
        $title .= "{$str}新房一手房，";
        $title .= "{$str}房产网信息网，最新开盘在售{$str}楼盘信息 - 安个家";

        $keyword = $title;
        $description = $title;

        return compact('title', 'keyword', 'description');

    }

}
