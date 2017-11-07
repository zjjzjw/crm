<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/login')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/login')); ?>
@extends('layouts.touch')

@section('navbar')
@overwrite

@section('content')
    <div class="logo">
        <img src="{!! isset($host) ? $host : ''!!}/image/logo.jpg">
    </div>

    <form id="form" action="{{route('user.post.login')}}" method="POST">
        <div class="user-info">
            <div class="phone">
                <i class="iconfont">&#xe604;</i>
                <input type="text" name="phone" id="phone" placeholder="请输入手机号" maxlength="11" value="{{old('phone')}}"
                       data-required="true"
                       data-pattern="^1(3|4|5|7|8)\d{9}$"
                       data-descriptions="phone"
                       data-describedby="phone-description"/>
            </div>
            <div class="password">
                <i class="iconfont">&#xe60a;</i>
                <input type="password" name="password" id="password" placeholder="请输入密码" maxlength="12"
                       value="{{old('password')}}"
                       data-pattern="^[0-9a-zA-z]{6,12}$"
                       data-required="true"
                       data-descriptions="password"
                       data-describedby="password-description"/>
            </div>
            <div id="phone-description" class="error-tip"></div>
            <div id="password-description" class="error-tip">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <div class="login-box">
            <input type="submit" class="login-btn" value="登录">
        </div>
    </form>

@endsection