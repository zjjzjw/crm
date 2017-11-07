<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/approval/list')); ?>
@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.detail-header', array('title' => "我的审批",'type' => 0))
        <ul class="hinder">
            <li>
                @can('user.approval.sale.list')
                    <a href="{{route('user.approval.sale.list')}}">销售线索<span>></span></a>
                @endcan
                @can('user.approval.hinder.list')
                    <a href="{{route('user.approval.hinder.list')}}">障碍输出<span>></span></a>
                @endcan
            </li>
        </ul>
    </div>
@endsection