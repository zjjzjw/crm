<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/login']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/login']); ?>
@extends('layouts.master')

@section('master.header')
@overwrite

@section('master.sidebar')
@overwrite

@section('master.breadcrumbs')
@overwrite

@section('master.title')
@overwrite


@section('master.content')
    <div class="login-box">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <form id="login-form" method="post" action="{{route('user.post.login')}}">
            <div class="login-input">
                <input type="text" placeholder="请输入手机号码" name="phone"
                       value="{{old('phone')}}"
                       data-validation="required length"
                       data-validation-length="max50"
                       data-validation-error-msg="请输入手机号码">
            </div>
            <div class="login-input">
                <input type="password" placeholder="请输入密码" name="password"
                       value="{{old('password')}}"
                       data-validation="required length"
                       data-validation-length="max50"
                       data-validation-error-msg="请输入密码">
            </div>
            <div class="text-center">
                <input type="submit" class="add-login" value="登录">
            </div>
        </form>
    </div>
@endsection

