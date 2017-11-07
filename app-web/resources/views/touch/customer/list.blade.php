<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/customer/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/customer/list', 'css/ui/list/list-items')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam(array(
        'pageInfo' => $appends ?? [],
        'listUrl'  => route($route_name ?? ''),
        'listType' => $route_name ?? ''
));
?>

@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', [
               'choose' => $choose,
               'add_permission' => 'customer.add'
    ])
    <div class="all-box">
        <div class="filter">
            <div id="menu" class="menu">
                <div id="menuinfo">
                    <div class="menunav" id="menunav">
                        <a href="{{route($route_name, array_merge($appends,[ 'sort' => ($appends['sort'] =='desc') ? 'asc' : 'desc']))}}"
                           id="place" class="menunav-row">
                            <span class="parentup" data-type="0">最新创建</span>
                            @if(($appends['sort'] ?? '') == 'desc')
                                <i class="g-touchicon-l revolve"></i>
                            @else
                                <i class="g-touchicon-l"></i>
                            @endif
                        </a>

                        <p id="mass" class="menunav-row">
                            <span class="parentup">总部所在地</span>
                            <i class="g-touchicon-l revolve"></i>
                        </p>

                        @if(!empty($search_users))
                            <p id="phase" class="menunav-row">
                                <span class="parentup">负责人</span>
                                <i class="g-touchicon-l revolve"></i>
                            </p>
                        @endif

                        <p id="phase" class="menunav-row">
                            <span class="parentup">更多</span>
                            <i class="g-touchicon-l revolve"></i>
                        </p>
                    </div>
                </div>
            </div>

            <div class="optionlist" id="optionlist" style="display: none;">
                <div class="menunav-info" style="display: none;"></div>
                {{--总部所在地--}}
                <div class="rsswitchinfo menunav-info moreinfo" id="rsswitchinfo" style="display: none">
                    {{--省份--}}
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
                    {{--市区--}}
                    @foreach($provinces as $province)
                        @if(!empty($province['nodes']))
                            <div class="public city-info" id="blockinfo-{{$province['id']}}" style="display: none;">
                                <div class="public-list auto-scoll">
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

                @if(!empty($search_users))
                    <div class="menunav-info" style="display: none">
                        <ul class="regionlist auto-scoll" id="regionlist">
                            <li>
                                <a class="@if(($appends['select_user_id'] ?? 0) == 0) active @endif"
                                   href="{{route($route_name, array_merge($appends, ['select_user_id' =>0]))}}">全部</a>
                            </li>
                            @foreach($search_users as $search_user)
                                <li>
                                    <a class="@if(($appends['select_user_id'] ?? 0) == $search_user['id']) active @endif"
                                       href="{{route($route_name, array_merge($appends, ['select_user_id' => $search_user['id']]))}}">{{$search_user['name'] or ''}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="menunav-info" style="display: none">
                    {{--项目--}}
                    <div class="regioninfo auto-scoll" id="regioninfo">
                        <ul class="regionlist" id="regionlist">
                            <li class="project-item">
                                <a data-id="0"
                                   class="@if(empty($appends['project_count_type']) &&
                                   empty($appends['build_project_count_type']) &&
                                   empty($appends['future_potential_type'])) active  @endif"
                                   href="{{route($route_name, array_merge($appends,
                                 [
                                    'project_count_type' => 0,
                                    'build_project_count_type' => 0,
                                    'future_potential_type' => 0,
                                  ]))}}">全部</a>
                            </li>
                            <li class="project-item">
                                <a class="@if(!empty($appends['project_count_type']))) active @endif"
                                   href="#" data-id="1">项目数量</a>
                            </li>
                            <li class="project-item">
                                <a class="@if(!empty($appends['build_project_count_type']))) active @endif"
                                   href="#" data-id="2">正在建设项目数量</a>
                            </li>
                            <li class="project-item">
                                <a class="@if(!empty($appends['future_potential_type'])) active @endif"
                                   href="#" data-id="3">未来潜量</a>
                            </li>
                        </ul>
                    </div>
                    {{--项目数量--}}
                    <div class="public project-info" id="project-num-1" style="display: none;">
                        <div class="public-list auto-scoll">
                            <a class="@if(($appends['project_count_type'] ?? 0) == 0) active @endif"
                               href="{{route($route_name, array_merge($appends, ['project_count_type' => 0]))}}">全部</a>
                            @foreach($project_count_types ?? [] as $key => $name)
                                <a class="@if(($appends['project_count_type'] ?? 0) == $key)) active @endif"
                                   href="{{route($route_name, array_merge($appends, ['project_count_type' => $key]))}}">
                                    {{$name or ''}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="public project-info" id="project-num-2" style="display: none;">
                        <div class="public-list auto-scoll">
                            <a class="@if(($appends['build_project_count_type'] ?? 0) == 0)  active @endif"
                               href="{{route($route_name, array_merge($appends, ['build_project_count_type' => 0]))}}">全部</a>
                            @foreach($build_project_count_types ?? [] as $key => $name)
                                <a class="@if(($appends['build_project_count_type'] ?? 0) == $key)  active @endif"
                                   href="{{route($route_name, array_merge($appends, ['build_project_count_type' => $key]))}}">
                                    {{$name or ''}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="public project-info" id="project-num-3" style="display: none;">
                        <div class="public-list auto-scoll">
                            <a class="@if(($appends['future_potential_type'] ?? 0) == 0) active @endif"
                               href="{{route($route_name, array_merge($appends, ['future_potential_type' => 0]))}}">全部</a>
                            @foreach($future_potential_types ?? [] as $key => $name)
                                <a class="@if(($appends['future_potential_type'] ?? 0) == $key) active @endif"
                                   href="{{route($route_name, array_merge($appends, ['future_potential_type' => $key]))}}">
                                    {{$name or ''}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div id="dialog" style="display: none;"></div>
        </div>
        {{-- 列表 --}}
        @include('partials.list-items',array('list_items' => $items ?? []))
    </div>



@endsection