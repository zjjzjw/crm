<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/list', 'css/ui/list/list-items')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam(array(
        'pageInfo' => $appends ?? ['page' => 1],
        'listUrl'  => route($route_name ?? ''),
        'listType' => $route_name ?? ''
));
?>
@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', [
               'choose' => $choose,
               'add_permission' => 'project.add' //添加项目的权限
    ])
    <div class="all-box">
        <div class="filter">

            <div id="menu" class="menu">
                <div id="menuinfo">
                    <div class="menunav" id="menunav">
                        <p id="mass" class="menunav-row">
                            <span class="parentup" data-type="0">体量</span><i class="g-touchicon-l revolve"></i>
                        </p>
                        <p id="phase" class="menunav-row">
                            <span class="parentup" data-type="1">合同签订时间</span><i class="g-touchicon-l revolve"></i>
                        </p>
                        @if(!empty($search_users))
                            <p id="principal" class="menunav-row">
                                <span class="parentup" data-type="2">负责人</span><i class="g-touchicon-l revolve"></i>
                            </p>
                        @endif
                    </div>
                </div>
            </div>


            <div class="optionlist" id="optionlist" style="display: none;">
                <!--体量-->
                <div class="mass menunav-info" id="priceinfo" style="display: none;">
                    <div class="pricelist auto-scoll">
                        @foreach($project_volume_types ?? [] as $id => $name)
                            <a rel="nofollow" class="@if(($appends['project_volume_type'] ?? 0) == $id) active  @endif"
                               href="{{route($route_name, array_merge($appends ,['project_volume_type' => $id]))}}">{{$name}}</a>
                        @endforeach
                    </div>
                </div>

                <!--所处阶段-->
                <div class="phase menunav-info" id="housetypeinfo" style="display: none; position: relative;">
                    <div class="pricelist auto-scoll">
                        <div class="div-date">
                            <span class="date-span">开始时间</span>
                            <input class="date-input start-date" type="date"
                                   value="{{$appends['start_time'] ?? \Carbon\Carbon::now()->format('Y-m-d')}}"/>
                        </div>
                        <div class="div-date">
                            <span class="date-span">结束时间</span>
                            <input class="date-input end-date" type="date"
                                   value="{{$appends['end_time'] ?? \Carbon\Carbon::now()->format('Y-m-d')}}"/>
                        </div>
                    </div>
                    <div class="date-button-div">
                        <input class="date-button" type="button" value="确定">
                    </div>
                </div>

                {{--负责人--}}
                @if(!empty($search_users))
                    <div class="principal menunav-info" id="housetypeinfo" style="display: none;">
                        <div class="pricelist auto-scoll">
                            <a rel="nofollow" class="@if(($appends['select_user_id'] ?? 0) == 0) active  @endif"
                               href="{{route('project.list', array_merge($appends, ['select_user_id' => 0]))}}">不限</a>
                            @foreach($search_users as $search_user)
                                <a rel="nofollow"
                                   class="@if(($appends['select_user_id'] ?? 0) == $search_user['id']) active  @endif"
                                   href="{{route('project.list', array_merge($appends, ['select_user_id' =>$search_user['id'] ]))}}">{{$search_user['name'] or ''}}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div id="dialog" style="display: none;"></div>

        </div>
        {{-- 列表 --}}
        @include('partials.list-items',array('list_items' => $items ?? []))
    </div>
@endsection