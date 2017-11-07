<?php Xinfang\Web\Http\Controllers\Resource::addJS(array('app/newhouse/detail','app/modules/ui/inventory/communityInfo'));?>
<?php Xinfang\Web\Http\Controllers\Resource::addCSS(array('css/newhouse/detail','css/ui/slider','css/ui/ui.success','css/ui/inventory/community-info'));?>
<?php Xinfang\Web\Http\Controllers\Resource::addCSS(array('css/ui/topAd'));?>
<?php
$subscribe_type = [1,2,3,4,5,6];

$push_info = ['变价通知','楼盘动态', '开盘通知','领取优惠', '预约看房','询最低价'];

$sub_title = ['楼盘变价信息会及时推送给您','楼盘最新动态会及时推送给您','楼盘开盘通知会及时推送给您','楼盘优惠信息会及时推送给您','我们将安排新房专家带您看房','我们将安排专人回复您最低价'];
?>
<?php
Xinfang\Web\Http\Controllers\Resource::addParam(array(
'loupanImages' => $result['loupan_images'],
'HouseImages' => $result['house_types'],
'lat' => $result['lat'],
'lng' => $result['lng'],
'loupanId' => $result['loupan_id'],
'subscribe_type' => $subscribe_type,
'isCollect' => $is_wished ?? 0
));
?>
@extends('layouts.touch')
@section('content')
    @if(empty($result['is_partner']) && $sandbox=='app')
        @include('partials.topad')
    @endif
    {{-- 轮播图 --}}
    @if(!empty($result['loupan_images']))
    <div id="swipe_box" class="swipe">
    </div>
    @else
        <img class="no-img" src="http://open.agjimg.com/non.png">
    @endif

    {{-- 房源title --}}
    <div class="house-title">
        <div class="house-item">
            <div class="house-name"><h2>{{$result['title']}}&nbsp;</h2><em>{{$result['house_status']}}</em><i></i></div>
            <p>{{$result['district']}}{{$result['address']}}</p>
        </div>
        <div class="tags">
            <a class="nclick" href="/loupan/map/{{$result['loupan_id']}}">
                <span class="txt-warning">
                    <i class="iconfont txt-warning">&#xe668;</i><p>地图</p>
                </span>
            </a>
        </div>
    </div>

    {{-- 房源详情 --}}
    <div class="house-detail house-common">
        <div class="detail-box">
            @if(!empty($result['unit_price']))
                <p class="unit-price">均价：<span><em>{{$result['unit_price']}}</em>&nbsp;元/平</span><span class="price-change subscribe-btn" data-title="{{$push_info[0]}}" data-subtitle="{{$sub_title[0]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['0']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="iconfont">&#xe665;</i>&nbsp;变价通知</span></p>
            @else
                <p class="unit-price">均价：待定<span class="price-change subscribe-btn" data-title="{{$push_info[0]}}" data-subtitle="{{$sub_title[0]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['0']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="iconfont">&#xe665;</i>&nbsp;变价通知</span></p>
            @endif
            <div class="detail-info">
                <p><span>面积：</span>{{$result['area']}}</p>
                <p><span>开盘：</span>{{$result['selling_date']}}</p>
                <p><span>装修：</span>{{$result['fitment_type']}}</p>
                <p><span>户数：</span>{{$result['house_plan']}}</p>
                <p><span>类型：</span>{{$result['property_type']}}</p>
                <p><span>产权：</span>{{$result['property_right']}}</p>
            </div>
        </div>
        <div class="look-more"><i class="iconfont">&#xe63b;</i>&nbsp;更多信息</div>
        <div class="more-info" style="display: none;">
            <p><span>楼盘位置：</span>{{$result['loop_line']}}</p>
            <p><span>开&nbsp;&nbsp;发&nbsp;&nbsp;商：</span>{{$result['builder']}}</p>
            <p><span>物业公司：</span>{{$result['manager']}}</p>
            <p><span>建筑类型：</span>{{$result['building_type']}}</p>
            <p><span>车位配比：</span>{{$result['car_rate']}}</p>
            <p><span>容&nbsp;&nbsp;积&nbsp;&nbsp;率：</span>{{$result['contain_rate']}}</p>
            <p><span>绿&nbsp;&nbsp;化&nbsp;&nbsp;率：</span>{{$result['green_pert']}}</p>
        </div>
    </div>

    {{-- 独家优惠or预约看房 --}}
    @if(!empty($result['discount_desc']))
        <div class="exclusive-privilege house-common">
            <h4>独家优惠</h4>
            <div class="tag-box">
            <span class="privilege-tag">惠</span>
            </div>
            <p class="describe">{{$result['discount_desc']}}</p>
            <p class="privilege-btn subscribe-btn" data-title="{{$push_info[3]}}" data-subtitle="{{$sub_title[3]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['3']}}">领取优惠</p>
        </div>
    @else
        <div class="look-house house-common">
            <h4>预约看房</h4>
            <p class="describe">新房专家带你看房</p>
            <p class="look-btn subscribe-btn" data-title="{{$push_info[4]}}" data-subtitle="{{$sub_title[4]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['4']}}"><i class="iconfont">&#xe667;</i>&nbsp;预约看房</p>
        </div>
    @endif

    {{-- 最新动态 --}}
    @if(!empty($result['dynamic']))
    <div class="dongtai house-common">
        <h4>最新动态</h4>
        <p class="title">{{$result['dynamic']['title']}}</p>
        <p class="comm-desc">
            <em>{{$result['dynamic']['content']}}</em>
            <a href="javascript:void(0);" class="open-all open-comm-desc">展开</a>
        </p>
        <p class="time">{{$result['dynamic']['time']}}</p>
        <div class="btn-box">
            <span class="dongtai-btn subscribe-btn" data-title="{{$push_info[1]}}" data-subtitle="{{$sub_title[1]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['1']}}">订阅新动态</span>
        </div>
    </div>
    @endif
    {{-- 安家服务 --}}
    <div class="house-common server">
        <h4>安家服务</h4>
        <ul>
            <li><span class="green">变</span><span class="title">变价通知</span><span class="detail-title">变价第一时间通知</span><span class="server-bianjia server-tags subscribe-btn" data-title="{{$push_info[0]}}" data-subtitle="{{$sub_title[0]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['0']}}">订阅</span></li>
            <li><span class="orange">低</span><span class="title">询最低价</span><span class="detail-title">专人专业解答</span><span class="server-dijia server-tags subscribe-btn" data-title="{{$push_info[5]}}" data-subtitle="{{$sub_title[5]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['5']}}">咨询</span></li>
            <li><span class="yellow">预</span><span class="title">预约看房</span><span class="detail-title">新房专家带你看房</span><span class="server-yuyue server-tags subscribe-btn" data-title="{{$push_info[4]}}" data-subtitle="{{$sub_title[4]}}" data-id="{{$result['loupan_id']}}" data-type="{{$subscribe_type['4']}}">预约</span></li>
        </ul>
    </div>

    {{-- 户型 --}}
    @if(!empty($result['house_types']))
    <div id="house_type" class="house-type house-common">
        <h4>户型</h4>
        <ul class="house-type-box">
            @foreach($result['house_types'] as $p => $types)
                <li data-num="{{$p}}" class="hx-item" @if($p>2)style="display: none;"@endif>
                    <a href="/loupan/house/{{$types['id']}}">
                        @if(!empty($types['cover_image']))
                        <img src="{{$types['cover_image']}}-250x250">
                        @else
                            <img class="no-img-type" src="http://open.agjimg.com/non.png-250x250">
                        @endif
                        <div class="type-detail">
                            <p class="type">{{$types['type']}}</p>
                            <p>{{$types['room']}}&nbsp;&nbsp;{{$types['area']}}</p>
                            <p class="price">{{$types['price']}}</p>
                        </div>
                    </a>
                </li>
            @endforeach
            @if($p>2)
            <div class="look-more-type up-down"><i class="iconfont">&#xe63b;</i>&nbsp;更多信息</div>
            @endif
            <div class="arrow-up up-down" style="display: none;"><i class="iconfont">&#xe640;</i>&nbsp;收起</div>
        </ul>
    </div>
    @endif
    {{-- 新房咨询 --}}
    @if(!empty($result['sale']['show_phone']))
    <div class="consult">
        <a class="tel-box" href="tel:{{$result['sale']['call_phone']}}">
            <p class="tel-info">
                <span class="num">{{$result['sale']['show_phone']}}</span>
                {{$result['sale']['desc']}}
            </p>
            <p class="phone"><i class="iconfont">&#xe612;</i></p>
        </a>
    </div>
    @endif

    {{-- 地图 --}}
    @if(isset($result['district_id']) && $result['district_id'] != 7109)
    <div class="house-map">
        <h4>位置和周边</h4>
        <a href="javascript:void(0);" id="map" class="map" data-lng="{{$result['lng']}}"
           data-lat="{{$result['lat']}}">
            <img>
        </a>
        <a href="/loupan/map/{{$result['loupan_id']}}">
            <p class="address">地址：{{$result['district']}}{{$result['address']}}</p>
        </a>
        @if(!empty($result['nearby_line']))
            <p class="metro"><i class="iconfont">&#xe666;</i>&nbsp;附近地铁</p>
            @foreach($result['nearby_line'] as $key => $nearby_line)
                <p>{{$nearby_line['line']}}{{$nearby_line['station']}}站(距离{{$nearby_line['distance']}}米)</p>
            @endforeach
        @endif
    </div>
    @endif


    {{-- 热卖好盘 --}}
    @if(!empty($result['hot_loupans']))
    <div class="hot-sale">
        <h4>热卖好盘</h4>
        <ul>
            @foreach($result['hot_loupans'] as $hot_sale)
                <li>
                    <a class="sale-item" href="/loupan/{{$hot_sale['city_jianpin']}}/{{$hot_sale['loupan_id']}}.html">
                        <img src="{{$hot_sale['image']}}-200x150">
                        <div class="right-box">
                            <p class="title">{{$hot_sale['loupan_name']}}<em>&nbsp;&nbsp;{{$hot_sale['house_status']}}</em></p>
                            <p>{{$hot_sale['district']}}</p>
                            <div class="tag-box">
                                @foreach($hot_sale['tags'] as $tags)
                                    <span>{{$tags}}</span>
                                @endforeach
                            </div>
                            @if(!empty($hot_sale['metro_stations']))
                                <span class="underline"><i class="iconfont">&#xe666;</i>{{implode('、',array_unique(
                                    explode(',',
                                    implode(',',
                                    array_map(function ($hot_sale) {
                                    return implode(',', array_pluck($hot_sale, 'number'));
                                    }, array_pluck($hot_sale['metro_stations'], 'lines'))
                                    )
                                    )
                                    )).'号线'}}</span>
                            @endif
                            @if(!empty($hot_sale['discount_desc']))
                                <p class="privilege"><em>惠</em>&nbsp;{{$hot_sale['discount_desc']}}</p>
                            @endif
                        </div>
                        <span class="price">{{$hot_sale['unit_price']}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- 楼盘编号 --}}
    <div class="loupan-num">楼盘编号&nbsp;{{$result['loupan_id']}}</div>
    <p class="add-bottom"></p>

    {{-- 下载APP --}}
    @include('partials.download',array('phone' => $result['sale']['call_phone']));

    {{-- 轮播图 --}}
    <div id="canvas_box" class="canvas" style="display:none;"></div>
    <div id="pop_box" class="canvas" style="display:none;"></div>

    <script type="text/html" id="swipe_img_tpl">
        <div class="image-list">
            <% for ( var i = 0; i < loupanImages.length; i++ ) { %>
            <div class="item">
                <img data-swipe="<%=loupanImages[i].url%>"/>
            </div>
            <% } %>
        </div>
        <% if (loupanImages.length > 0) { %>
        <div class="image-type-index">
            <div>
                <span>1/<%=loupanImages.length%></span>
            </div>
        </div>
        <% } %>
    </script>
    <!-- 点击大图 -->
    <script type="text/html" id="swipe_expand_img_tpl">
        <div class="image-list">
            <% for ( var i = 0; i < loupanImages.length; i++ ) { %>
            <div class="item">
                <img data-swipe="<%=loupanImages[i].url%>"/>
            </div>
            <% } %>
        </div>
        <% if (loupanImages.length > 0) { %>
        <div class="image-type-index-pop">
            <div>
                <span>1/<%=loupanImages.length%></span>
            </div>
        </div>
        <% } %>
        <% if (loupanImages.length > 0) { %>
        <div class="image-type-wrap">
            <span><%=loupanImages[0].name%></span>
        </div>
        <% } %>
    </script>
    <!-- 订阅 -->
    <script type="text/html" id="subscriptTpl">
        <p class="close-subscript">
            <i class="iconfont">&#xe60c;</i>
        </p>
        <div class="reg-title">登录</div>
        <p class="tips"></p>
        <form class="box-tel" name="box-tel">
            <div class="phone-num">
                <input id="tel-num" class="tel-num" type="tel" placeholder="请输入手机号" maxlength="11"/>
                <a onclick="javascript:;" class="send-code-num">获取验证码</a>
                <div class="add"></div>
            </div>
            <div class="identify-num">
                <input id="code-num" class="code-num" type="tel" placeholder="请输入验证码" maxlength="6"/>
            </div>
            <!--验证码不正确-->
            <p class="error-tip txt-error" id="errorInfo"></p>
            <a id="box-btn" href="javascript:;" class="button box-btn">确定</a>
        </form>
    </script>
    <script type="text/html" id="successTpl">
        <div class="close-all">
            <p id="close-tip" class="close suc-btn"><i class="iconfont">&#xe60c;</i></p>
            <div class="success-box">
                <i class="iconfont suc-icon">&#xe615;</i><span class="suc-tip">提交成功</span>
            </div>
            <p class="suc-title"></p>
            <a class="close-btn suc-btn" href="javascript:;">关闭</a>
        </div>
    </script>
@endsection
