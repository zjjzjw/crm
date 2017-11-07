<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/list')); ?>
@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.detail-header', array('title' => "个人中心",'type' =>""))
        <div class="list-box">
            <a href="{{route('user.info')}}"><i class="iconfont icon-info">&#xe665;</i>个人信息<span>></span></a>
            @can('user.card.list')
                <a href="{{route('user.card.list')}}"><i class="iconfont icon-card">&#xe616;</i>名片夹<span>></span></a>
            @endcan
            <a href="{{route('user.contacts')}}"><i class="iconfont icon-contacts">&#xe61e;</i>通讯录<span>></span></a>
            <a href="{{route('user.approval.list')}}"><i class="iconfont icon-approval">
                    &#xe63b;</i>我的审批<span>></span></a>
            @can('user.sign-task.distribution')
                <a href="{{route('user.sign-task.distribution')}}"><i class="iconfont icon-opinion">
                        &#xe622;</i>任务分配<span>></span></a>
            @endcan
            <a href="{{route('user.opinion')}}"><i class="iconfont icon-opinion">&#xe60f;</i>意见反馈<span>></span></a>
            <a href="{{route('user.set')}}"><i class="iconfont icon-set">&#xe64b;</i>设置<span>></span></a>
        </div>
    </div>
@endsection