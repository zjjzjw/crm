<?php Xinfang\Web\Http\Controllers\Resource::addCSS(array('css/newhouse/houseType','css/ui/slider'));?>
<?php Xinfang\Web\Http\Controllers\Resource::addJS(array('app/newhouse/houseType'));?>
<?php
Xinfang\Web\Http\Controllers\Resource::addParam(array(
'loupanImages' => $result['images']
));
?>
@extends('layouts.touch')
@section('content')
{{-- 轮播图 --}}
    @if(!empty($result['images']))
    <div id="swipe_box" class="swipe">
    </div>
    @else
        <img class="no-img-type" src="http://open.agjimg.com/non.png-250x250">
    @endif
    <div class="common-info">
        <p class="title">{{$result['name']}}&nbsp;&nbsp;{{$result['bedrooms']}}室{{$result['living_room']}}厅{{$result['bathrooms']}}卫&nbsp;
            @foreach($result['tags'] as $tags)
                <span>{{$tags}}</span>
            @endforeach
        </p>
        <p class="total-price">总价：<span>{{$result['price']}}</span></p>
        <p class="area">面积：<span>{{$result['area']}}</span></p>
        <p class="orientation">朝向：<span>{{$result['orientation']}}</span></p>
    </div>
    @if(!empty($result['analysis']))
    <P class="type-desc">户型解析</P>
    <div class="type-detail">
        @foreach($result['analysis'] as $analysis)
            <div class="type-item">
                <p class="detail-name">{{$analysis['name']}}:</p><p class="detail-desc">{{$analysis['desc']}}</p>
            </div>
        @endforeach
    </div>
    @endif
    {{-- 楼盘编号 --}}
    <div class="loupan-num">楼盘编号&nbsp;{{$id}}</div>
    <p class="add-bottom"></p>

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
@endsection