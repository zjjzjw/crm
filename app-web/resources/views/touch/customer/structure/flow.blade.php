<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/customer/structure/flow')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/structure/flow')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam(array(
        'customer_id' => $customer_id ?? 0,
        'id'          => $id ?? 0,
        'parent_id'   => $parent_id ?? 0
));

?>
@extends('layouts.touch')
@section('content')
    <div class="chart-content">
    @include('partials.detail-header', array('title' => "组织架构",'type' => 0))
    <!--根据li length判断展示部分-->
        @if(empty($structure))
            <a href="{{route('customer.structure.edit', ['customer_id' => $customer_id, 'parent_id' => 0, 'id'=> 0])}}"
               class="add-structure">
                <p class="">点击添加内容</p>
            </a>
        @else
            <ul id="org" style="display:none">
                {!! $html or '' !!}
            </ul>
            <div id="chart" class="orgChart"></div>
        @endif
    </div>
    {{--编辑 添加or 删除--}}
    <script type="text/html" id="editTpl">
        <div class="edit-box">
            <p class="close"><i class="iconfont close-btn">&#xe621;</i></p>
            <div class="choose">
                <a class="add" href="javascript:void(0);"><i class="iconfont">&#xe61f;</i>添加</a>
                <a class="detail" href="javascript:void(0);"><i class="iconfont">
                        &#xe60e;</i>详情</a>
                <a class="delete" href="javascript:;"><i class="iconfont">&#xe603;</i>删除</a>
            </div>
        </div>
    </script>
    {{--权限提示--}}
    @include('partials.limit-pop')
    <script src="{!! isset($host) ? $host : ''!!}/js/lib/structure/jquery.js"></script>
    <script src="{!! isset($host) ? $host : ''!!}/js/lib/structure/jquery-ui.js"></script>
    <script src="{!! isset($host) ? $host : ''!!}/js/lib/structure/structure.js"></script>
@endsection