<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/help/list')); ?>

@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.detail-header',
        [
            'title' => "帮助中心",
            'type' => 0
        ])
    <div class="list-box">
        <div class="list-type">
            <div class="left-box"><p>销售线索</p></div>
            <ul class="right-box">
                <li><a href="{{route('help.sales.detail',['type' => 1])}}">创建销售线索</a></li>
                <li><a href="{{route('help.sales.detail',['type' => 2])}}">编辑、删除销售线索</a></li>
                <li><a href="{{route('help.sales.detail',['type' => 3])}}">分配销售线索</a></li>
                <li><a href="{{route('help.sales.detail',['type' => 4])}}">认领销售线索</a></li>
            </ul>
        </div>
        <div class="list-type">
            <div class="left-box"><p>项目管理</p></div>
            <ul class="right-box">
                <li><a href="{{route('help.project.detail',['type' => 1])}}">创建项目</a></li>
                <li><a href="{{route('help.project.detail',['type' => 2])}}">编辑、删除项目</a></li>
                <li><a href="{{route('help.project.detail',['type' => 3])}}">组织架构</a></li>
                <li><a href="{{route('help.project.detail',['type' => 4])}}">采购流程</a></li>
                <li><a href="{{route('help.project.detail',['type' => 5])}}">优劣势分析</a></li>
                <li><a href="{{route('help.project.detail',['type' => 6])}}">目标设置-销售进度图</a></li>
            </ul>
        </div>
        <div class="list-type">
            <div class="left-box"><p>客户管理</p></div>
            <ul class="right-box">
                <li><a href="{{route('help.customer.detail',['type' => 1])}}">创建客户信息</a></li>
                <li><a href="{{route('help.customer.detail',['type' => 2])}}">编辑、删除客户信息</a></li>
            </ul>
        </div>
        <div class="list-type">
            <div class="left-box"><p>合同管理</p></div>
            <ul class="right-box">
                <li><a href="{{route('help.contract.detail',['type' => 1])}}">创建合同</a></li>
                <li><a href="{{route('help.contract.detail',['type' => 2])}}">回款详情</a></li>
                <li><a href="{{route('help.contract.detail',['type' => 3])}}">回款计划和回款详情</a></li>
            </ul>
        </div>
        <div class="list-type">
            <div class="left-box"><p>我</p></div>
            <ul class="right-box">
                <li><a href="{{route('help.user.detail',['type' => 1])}}">名片夹</a></li>
                <li><a href="{{route('help.user.detail',['type' => 2])}}">我的审批</a></li>
            </ul>
        </div>
    </div>
@endsection