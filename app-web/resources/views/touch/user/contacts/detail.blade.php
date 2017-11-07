<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/contacts/detail')); ?>
@extends('layouts.touch')
@section('content')
    <div class="info-content">
        @include('partials.detail-header', array('title' => "个人信息",'type' => 0))
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
                @if(!empty($phone))
                    <p>手机<a href="tel:{{$phone}}"><span>{{$phone or ''}}</span></a></p>
                @endif
                <p>邮箱<span>{{$email or ''}}</span></p>
            </div>
        </div>
    </div>
@endsection