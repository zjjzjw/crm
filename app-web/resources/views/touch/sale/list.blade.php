<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/sale/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(
        array(
                'css/sale/list',
                'css/ui/list/list-items',
                'css/ui/list/list-header'
        )
); ?>
<?php

Huifang\Web\Http\Controllers\Resource::addParam(array(
        'pageInfo' => $appends ?? [],
        'listUrl'  => route($route_name ?? '') ?? '',
        'listType' => $route_name ?? '',
));
?>
@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', array('choose' => $choose, 'add_permission' => 'sale.add'))
    <div class="all-box">
        <div class="filter">
            <div id="menu" class="menu">
                <div id="menuinfo">
                    <div class="menunav" id="menunav">
                        <p id="place" class="menunav-row">
                            <span class="parentup" data-type="0">所在地</span><i class="g-touchicon-l revolve"></i>
                        </p>
                        <p id="mass" class="menunav-row">
                            <span class="parentup" data-type="1">体量</span><i class="g-touchicon-l revolve"></i>
                        </p>
                        <p id="select" class="menunav-row">
                            <span class="parentup" data-type="2">筛选</span><i class="g-touchicon-l revolve"></i>
                        </p>
                    </div>
                </div>
            </div>

            <div class="optionlist" id="optionlist" style="display: none;">
                <!--所在地-->
                <div class="rsswitchinfo menunav-info moreinfo" id="rsswitchinfo" style="display: none;">
                    <!--省份-->
                    <div class="regioninfo auto-scoll" id="regioninfo">
                        <ul class="regionlist" id="regionlist">
                            <li class="region-item">
                                <a data-id="0" class="@if(($appends['province_id'] ?? 0) == 0) active @endif"
                                   href="{{route($route_name, array_merge($appends,['province_id' => 0, 'city_id' => 0]))}}">全部</a>
                            </li>
                            @foreach($provinces as $province)
                                <li class="region-item">
                                    <a class="@if(($appends['province_id'] ?? 0) == $province['id']) active @endif"
                                       data-id="{{$province['id']}}" href="#">
                                        {{$province['name']}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!--市-->
                    @foreach($provinces as $province)
                        @if(!empty($province['nodes']))
                            <div class="city-info" id="blockinfo-{{$province['id']}}" style="display: none;">
                                <div class="city-list auto-scoll">
                                    <a class="@if(($appends['city_id'] ?? 0) == 0) active @endif"
                                       href="{{route($route_name, array_merge($appends, ['province_id' => $province['id'],'city_id' => 0 ]))}}">全部</a>
                                    @foreach($province['nodes'] as $city)
                                        <a class="@if(($appends['city_id'] ?? 0) == $city['id']) active @endif"
                                           href="{{route($route_name, array_merge($appends ,['province_id' => $province['id'],'city_id' => $city['id']]))}}"
                                           data-id="{{$city['id'] ?? 0}}">{{$city['name'] ?? ''}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!--体量-->
                <div class="mass menunav-info" id="priceinfo" style="display: none;">
                    <div class="pricelist auto-scoll">
                        @foreach($project_volume_types as $id => $name)
                            <a rel="nofollow" class="@if(($appends['project_volume_type'] ?? 0) == $id) active @endif"
                               href="{{route($route_name, array_merge($appends ,['project_volume_type' => $id]))}}">{{$name}}</a>
                        @endforeach
                    </div>
                </div>

                <!--筛选-->
                <div class="rsswitchinfo menunav-info moreinfo" id="selectinfo" style="display: none;">
                    <div class="regioninfo auto-scoll" id="regioninfo">
                        <ul class="regionlist" id="regionlist">
                            <li class="region-item">
                                <a class="phase" href="#">所处阶段</a>
                            </li>
                            <li class="region-item">
                                <a class="close-info" href="#">关闭线索原因</a>
                            </li>
                            @if(!empty($search_users))
                                <li class="region-item">
                                    <a class="principal" href="#">负责人</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!--所处阶段-->
                    <div class="city-info" id="phase" style="display: none;">
                        <div class="city-list auto-scoll">
                            <div class="city-list auto-scoll">
                                @foreach($project_step_types as $id => $name)
                                    <a rel="nofollow"
                                       class="@if(($appends['project_step_type'] ?? 0) == $id) active @endif"
                                       href="{{route($route_name, array_merge($appends ,['project_step_type' => $id ]))}}">{{$name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--关闭线索原因-->
                    <div class="city-info" id="closeInfo" style="display: none;">
                        <div class="city-list auto-scoll">
                            <div class="city-list auto-scoll">
                                <a rel="nofollow"
                                   class="@if(($appends['close_status'] ?? 0)  == 0) active @endif"
                                   href="{{route($route_name, array_merge($appends ,['close_status' => 0]))}}">全部</a>
                                @foreach($sale_close_statuses as $id => $name)
                                    <a rel="nofollow"
                                       class="@if(($appends['close_status'] ?? 0)  == $id) active @endif"
                                       href="{{route($route_name, array_merge($appends ,['close_status' => $id ]))}}">{{$name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @if(!empty($search_users))
                    <!-- 负责人 -->
                        <div class="city-info" id="principal" style="display: none;">
                            <div class="city-list auto-scoll">
                                <div class="city-list auto-scoll">
                                    <a rel="nofollow"
                                       class="@if(($appends['select_user_id'] ?? 0) == 0) active @endif"
                                       href="{{route($route_name, array_merge($appends ,['select_user_id' => 0]))}}">全部</a>
                                    @foreach($search_users as $search_user)
                                        <a rel="nofollow"
                                           class="@if(($appends['select_user_id'] ?? 0) == $search_user['id']) active @endif"
                                           href="{{route($route_name, array_merge($appends ,['select_user_id' => $search_user['id']]))}}">{{$search_user['name'] or ''}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div id="dialog" style="display: none;"></div>
        </div>
        {{-- 列表 --}}
        @include('partials.list-items',array('list_items' => $items ?? []))
    </div>
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection