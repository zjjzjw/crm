<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/purchase/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/purchase/list')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id ?? 0
]);
$choose = [
        'title'        => "采购流程",
        'url'          => route('project.purchase.edit', ['project_id' => $project_id ?? 0, 'id' => 0]),
        'choose_items' => []
]
?>
@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', array('choose' => $choose, 'add_permission' => 'project.purchase.add'))

    <div class="flow-content">
        @if(!empty($project_purchases))
            <ul class="time-box">

                @foreach($project_purchases as $key => $project_purchase_items)
                    <li class="item-time">
                        <span class="circle"></span>
                        <p class="time">
                            {{\Carbon\Carbon::parse($key)->format('m-d')}}
                            <i class="iconfont show-icon">&#xe624;</i>
                        </p>
                        <ul class="event-box" style="display: none;">
                            @foreach($project_purchase_items as $item)
                                <li class="item-event">
                                    <a href="{{route('project.purchase.detail',['project_id' => $item['project_id'], 'id' => $item['id'] ])}}">
                                        <span class="purchase-name">{{$item['name'] or ''}}</span>
                                        <span>{{$item['event_desc'] or ''}}</span>
                                        <i class="iconfont">&#xe626;</i></a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="no-data">暂无事件描述，请在右上角选择添加！</p>
        @endif
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
@endsection