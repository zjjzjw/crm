<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/info')); ?>
@extends('layouts.touch')
@section('content')
    <div class="info-content">
        @include('partials.detail-header', array('title' => "个人信息",'type' =>""))
        <div class="info-box">
            <div class="pic-box">
                @if(!empty($user_images[0]['url']))
                    <img src="{{$user_images[0]['url']}}">
                @else
                    <img src="{!! isset($host) ? $host : ''!!}/image/user.jpg">
                @endif
                <p class="name">{{$name or ''}}</p>
            </div>
            <div class="detail-info">
                <p>部门<span>{{$depart_name or ''}}</span></p>
                <p>职位<span>{{$role_name or ''}}</span></p>
                <p>手机<span>{{$phone or ''}}</span></p>
                <p>邮箱<span>{{$email or ''}}</span></p>
            </div>
        </div>
    </div>
@endsection