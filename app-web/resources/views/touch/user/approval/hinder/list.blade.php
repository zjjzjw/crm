<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/list/list-items')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/approval/hinder/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/approval/hinder/list')); ?>

<?php

Huifang\Web\Http\Controllers\Resource::addParam(array(
        'pageInfo' => $appends ?? [],
        'listType' => $route_name ?? '',
));
?>

@extends('layouts.touch')
@section('content')
    <div class="list-content">

        @include('partials.list-header', array('choose' => ['title' => '目标障碍审核'], 'add_permission' => ''))

        <div class="top-choose">
            <div class="choose-box">
                <a href="{{route('user.approval.hinder.list', array_merge($appends,
                ['sort' => $appends['sort']  == 'asc' ? 'desc' : 'asc']))}}"
                   class="time">提交时间
                    <i class="iconfont up @if($appends['sort']  == 'asc') active @endif">
                        &#xe646;</i>
                    <i class="iconfont down @if($appends['sort']  == 'desc') active @endif">
                        &#xe646;</i></a>
                <p id="mass" class="menunav-row">
                    <span class="parentup" data-type="0">审核状态
                        <i class="g-touchicon-l revolve"></i>
                    </span>
                </p>
                <p id="phase" class="menunav-row">
                    <span class="parentup" data-type="1">提交人
                        <i class="g-touchicon-l revolve"></i>
                    </span>
                </p>
            </div>
        </div>

        <div class="optionlist" id="optionlist" style="display: none;">
            {{--审核状态--}}
            <div class="mass menunav-info" style="display: none;">
                <div class="pricelist auto-scoll">
                    <a rel="nofollow" class="@if(($appends['status'] ?? 0) == 0) active @endif"
                       href="{{route('user.approval.hinder.list', array_merge($appends,['status' => 0]))}}">全部</a>
                    @foreach($aim_hinder_statuses as $key => $name)
                        <a rel="nofollow" class="@if(($appends['status'] ?? 0) == $key) active @endif"
                           href="{{route('user.approval.hinder.list', array_merge($appends,['status' => $key ]))}}">{{$name}}</a>
                    @endforeach
                </div>
            </div>
            {{--提交人--}}
            <div class="phase menunav-info" style="display: none;">
                <div class="principal">
                    <div class="auto-scoll">
                        <a rel="nofollow" class="@if(($appends['select_user_id'] ?? 0) == 0) active @endif"
                           href="{{route('user.approval.hinder.list', array_merge($appends, ['select_user_id' => 0]))}}">
                            全部
                        </a>
                        @foreach($search_users as $search_user)
                            <a rel="nofollow"
                               class="@if(($appends['select_user_id'] ?? 0) == $search_user['id']) active @endif"
                               href="{{route('user.approval.hinder.list', array_merge($appends, ['select_user_id' => $search_user['id']]))}}">
                                {{$search_user['name'] or ''}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- 列表 --}}
        @include('partials.list-items',array('list_items' => $items ?? []))

        <div id="dialog" style="display: none;"></div>
    </div>
@endsection