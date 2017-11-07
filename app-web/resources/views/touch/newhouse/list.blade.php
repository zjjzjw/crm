<?php Xinfang\Web\Http\Controllers\Resource::addCSS(array('css/newhouse/list'));?>
<?php Xinfang\Web\Http\Controllers\Resource::addJS(array('app/newhouse/list'));?>
<?php
$result['pager']['page'] = 1;
$result['pager']['block_ids'] = $params['block_ids']?? '';
$result['pager']['district_ids'] = $params['district_ids']?? '';
Xinfang\Web\Http\Controllers\Resource::addParam(array(
'district_list' => $data['district_list'],
'district_block_list' => $data['district_block_list'],
'unit_price' => $data['unit_price'],
'property_type'=>$data['property_type'],
'listUrl' => '/loupan/' . $city_jianpin,
'city_jianpin' => $city_jianpin,
'pageInfo' => $result['pager']
));
?>

@extends('layouts.touch')
@section('content')
    <section class="search-house-wrap">
        <span class="{{ empty($community_name) && empty($keyword) ? 'txt-info' : ''}}" id="search_house" data-placeholder="搜索楼盘名称">@if(!empty($community_name)){{htmlspecialchars($community_name)}}@elseif(!empty($keyword)){{htmlspecialchars($keyword)}}@else搜索楼盘名称@endif</span>
            <i class="iconfont icon-cancel" id="search_house_cancle" style="display:@if(!empty($community_name) || !empty($keyword)) {!!'inline'!!}@else{!!'none'!!}@endif;">&#xe605;</i>
    </section>
   <div class="list-filter">
        <?php $option = $params; $filter_keys = []; ?>
        <a href="javascript:void(0);" class="filter-title">
                @if(!empty($params['block_ids']) && !empty($params['district_ids']) && isset($data['district_block_list'][$params['district_ids']]))
                    @foreach($data['district_block_list'][$params['district_ids']] as $block)
                        @if($params['block_ids'] == $block['id'])
                            <span>{!!$block['name']!!}</span><i class="iconfont filter-icon">&#xe60b;</i>
                            <?php array_push($filter_keys, $block['name']); break; ?>
                        @endif
                    @endforeach
                @elseif(!empty($params['district_ids']) && empty($params['block_ids']))
                    @foreach($data['district_list'] as $district)
                        @if($params['district_ids'] == $district['id'])
                            <span>{!!$district['name']!!}</span><i class="iconfont filter-icon">&#xe60b;</i>
                            <?php break;?>
                        @endif
                    @endforeach
                @else
                    <span>区域</span><i class="iconfont filter-icon">&#xe60b;</i>
                @endif
            </a>
        <a href="javascript:void(0);" class="filter-title">
            @if(isset($params['min_price']) && isset($params['max_price']))
                <?php $min_price = $params['min_price'] / 10000; $max_price = $params['max_price'] / 10000 ?>
                <span><?php if (empty($min_price)) {
                        array_push($filter_keys, $max_price . '万元以下');
                        echo $max_price . '万元以下';
                    } elseif ($min_price == 1000) {
                        array_push($filter_keys, '10万元以上');
                        echo '10万元以上';
                    } else {
                        array_push($filter_keys, $min_price . '-' . $max_price . '万元');
                        echo $min_price . '-' . $max_price . '万元';
                    }?></span><i class="iconfont filter-icon">&#xe60b;</i>
            @else
                <span>价格</span><i class="iconfont filter-icon">&#xe60b;</i>
            @endif
        </a>

        <a href="javascript:void(0);" class="filter-title">
            @if(isset($params['min_bedrooms']) && isset($params['max_bedrooms']))
                @if($params['min_bedrooms'] == 0)
                    <span>不限</span><i class="iconfont filter-icon">&#xe60b;</i>
                    <?php array_push($filter_keys, "不限"); ?>
                @elseif($params['min_bedrooms'] == 1)
                    <span>一室</span><i class="iconfont filter-icon">&#xe60b;</i>
                    <?php array_push($filter_keys, "一室"); ?>
                @elseif($params['min_bedrooms'] == 2)
                    <span>二室</span><i class="iconfont filter-icon">&#xe60b;</i>
                    <?php array_push($filter_keys, "二室"); ?>
                @elseif($params['min_bedrooms'] == 3)
                    <span>三室</span><i class="iconfont filter-icon">&#xe60b;</i>
                    <?php array_push($filter_keys, "三室"); ?>
                @elseif($params['min_bedrooms'] == 4)
                    <span>四室</span><i class="iconfont filter-icon">&#xe60b;</i>
                    <?php array_push($filter_keys, "四室"); ?>
                @elseif($params['min_bedrooms'] == 5)
                    <span>五室及以上</span><i class="iconfont filter-icon">&#xe60b;</i>
                    <?php array_push($filter_keys, "五室及以上"); ?>
                @endif
            @else
                <span>户型</span><i class="iconfont filter-icon">&#xe60b;</i>
            @endif
        </a>
        <a href="javascript:void(0);" class="filter-title no-border">
            @if(isset($params['property_type']))
                @if($params['property_type'] == 0)
                    <span>不限</span><i class="iconfont filter-icon">&#xe60b;</i>
                @elseif($params['property_type'] == 1)
                    <span>别墅</span><i class="iconfont filter-icon">&#xe60b;</i>
                @elseif($params['property_type'] == 2)
                    <span>住宅</span><i class="iconfont filter-icon">&#xe60b;</i>
                @elseif($params['property_type'] == 3)
                    <span>商住</span><i class="iconfont filter-icon">&#xe60b;</i>
                @elseif($params['property_type'] == 4)
                    <span>商铺</span><i class="iconfont filter-icon">&#xe60b;</i>
                @elseif($params['property_type'] == 5)
                    <span>写字楼</span><i class="iconfont filter-icon">&#xe60b;</i>
                @endif
            @else
                <span>类型</span><i class="iconfont filter-icon">&#xe60b;</i>
            @endif
        </a>

        <div class="h3 filter-detail">
            <div class="filter-area">
                <div class="wrapper area-left">
                    <div id="wrapper-0">
                        <a href="/loupan/{{$city_jianpin}}">不限</a>
                        <?php $district_ids = isset($option['district_ids']) ? $option['district_ids'] : 0; ?>
                        @foreach($data['district_list'] as $district)
                            <a <?php if($district_ids == $district['id']){?> class="cur-bg"
                               <?php array_unshift($filter_keys, $district['name']); }?> href="javascript:void(0);">{!!$district['name']!!}</a>
                        @endforeach
                    </div>
                </div>
                <div class="wrapper area-right">
                    <div id="wrapper-1">
                        <div id="area-right-1" class="block">
                            </div>
                        <?php $i = 2;?>
                        @foreach($data['district_list'] as $district)
                            <div id="area-right-{!!$i!!}" class="block"
                                 <?php if(!empty($option['district_ids']) && $option['district_ids'] == $district['id']){?> style="display: block" <?php }?>>
                                @if(isset($data['district_block_list'][$district['id']]))
                                    <?php $di = $params;$di['district_ids'] = $district['id'];unset($di['district_ids']);unset($di['block_ids']);$option['district_ids'] = !empty($option['district_ids']) ? $option['district_ids'] : '';$option['block_ids'] = isset($option['block_ids']) ? $option['block_ids'] : '';?>
                                    <a class="{{($option['district_ids'] == $district['id'] && $option['block_ids'] == '') ? 'cur-item': ''}} nclick"
                                       href="{{$district['url']}}">不限</a>
                                    @foreach($data['district_block_list'][$district['id']] as $block)
                                        <?php $di = $params;$di['district_ids'] = $district['id'];$di['block_ids'] = $block['id'];unset($di['district_ids']);unset($di['block_ids']); ?>
                                        <?php $option['block_ids'] = !empty($params['block_ids']) ? $params['block_ids'] : '';?>
                                        @if($option['block_ids'] == $block['id'])
                                            <a class="cur-item nclick"
                                               href="?{!!http_build_query($di)!!}">{!!$block['name']!!}</a>
                                        @else
                                            <a class="nclick"
                                               href="{{$block['url']}}?{!!http_build_query($di)!!}">{!!$block['name']!!}</a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <?php ++$i;?>
                        @endforeach
                    </div>
                </div>

            </div>

            <?php $new_page_params = $params;?>
            <?php unset($params['district_ids']);unset($params['block_ids']);?>

            <div class="wrapper">
                <div id="wrapper-2" class="filter-list">
                    <?php $p = $params;unset($p['min_price']);unset($p['max_price']);?>
                    <?php $option['max_price'] = !empty($option['max_price']) ? $option['max_price'] : 0;?>
                    <a class="nclick {{($option['max_price'] == 0) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">不限</a>
                    <?php $p = $params;$p['min_price'] = 0;$p['max_price'] = 15000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">1.5万以下</a>
                    <?php $p = $params;$p['min_price'] = 15000;$p['max_price'] = 20000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">1.5-2万</a>
                    <?php $p = $params;$p['min_price'] = 20000;$p['max_price'] = 25000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">2-2.5万元</a>
                    <?php $p = $params;$p['min_price'] = 25000;$p['max_price'] = 30000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">2.5-3万元</a>
                    <?php $p = $params;$p['min_price'] = 30000;$p['max_price'] = 40000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">3-4万元</a>
                    <?php $p = $params;$p['min_price'] = 40000;$p['max_price'] = 50000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">4-5万元</a>
                    <?php $p = $params;$p['min_price'] = 50000;$p['max_price'] = 70000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">5-7万元</a>
                    <?php $p = $params;$p['min_price'] = 70000;$p['max_price'] = 100000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">7-10万元</a>
                    <?php $p = $params;$p['min_price'] = 100000;$p['max_price'] = 100000000;?>
                    <a class="nclick {{($option['max_price'] == $p['max_price']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($p)!!}">10万以上</a>
                </div>
            </div>

            <div class="wrapper">
                <div id="wrapper-3" class="filter-list">
                    <?php $b = $params;unset($b['min_bedrooms']);unset($b['max_bedrooms']);?>
                    <?php $option['min_bedrooms'] = !empty($option['min_bedrooms']) ? $option['min_bedrooms'] : 0;?>
                    <a class="nclick {{($option['min_bedrooms'] == 0) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($b)!!}">不限</a>
                    <?php $b = $params;$b['min_bedrooms'] = 1;$b['max_bedrooms'] = 1;?>
                    <a class="nclick {{($option['min_bedrooms'] == $b['min_bedrooms']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($b)!!}">一室</a>
                    <?php $b = $params;$b['min_bedrooms'] = 2;$b['max_bedrooms'] = 2;?>
                    <a class="nclick {{($option['min_bedrooms'] == $b['min_bedrooms']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($b)!!}">二室</a>
                    <?php $b = $params;$b['min_bedrooms'] = 3;$b['max_bedrooms'] = 3;?>
                    <a class="nclick {{($option['min_bedrooms'] == $b['min_bedrooms']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($b)!!}">三室</a>
                    <?php $b = $params;$b['min_bedrooms'] = 4;$b['max_bedrooms'] = 4;?>
                    <a class="nclick {{($option['min_bedrooms'] == $b['min_bedrooms']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($b)!!}">四室</a>
                    <?php $b = $params;$b['min_bedrooms'] = 5;$b['max_bedrooms'] = 100;?>
                    <a class="nclick {{($option['min_bedrooms'] == $b['min_bedrooms']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($b)!!}">五室及以上</a>
                </div>
            </div>

            <div class="wrapper">
                <div id="wrapper-4" class="filter-list">
                    <?php $option['property_type'] = !empty($option['property_type']) ? $option['property_type'] : '';?>
                    <?php $s = $params;$s['property_type'] = 0;?>
                    <a class="nclick {{($option['property_type'] == $s['property_type']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($s)!!}">不限</a>
                    <?php $s = $params;$s['property_type'] = 2;?>
                    <a class="nclick {{($option['property_type'] == $s['property_type']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($s)!!}">住宅</a>
                    <?php $s = $params;$s['property_type'] = 1;?>
                    <a class="nclick {{($option['property_type'] == $s['property_type']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($s)!!}">别墅</a>
                    <?php $s = $params;$s['property_type'] = 3;?>
                    <a class="nclick {{($option['property_type'] == $s['property_type']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($s)!!}">商住</a>
                    <?php $s = $params;$s['property_type'] = 4;?>
                    <a class="nclick {{($option['property_type'] == $s['property_type']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($s)!!}">商铺</a>
                    <?php $s = $params;$s['property_type'] = 5;?>
                    <a class="nclick {{($option['property_type'] == $s['property_type']) ? 'cur-item' : ''}}"
                       href="?{!!http_build_query($s)!!}">写字楼</a>
                </div>
            </div>
        </div>
        <section class="tip-outter">
            <div class="err-tip">
                无法获取到您的地理位置
            </div>
        </section>
    </div>
    @include('partials.personalList', array('properties' => $result['items']))
    <section id="auto_wrap" class="auto-wrap" style="display:none;">
        @include('partials.autocomplete', array('items' => $data['recommend_district'] ?? []))
    </section>
    <div class="mask"></div>
@endsection