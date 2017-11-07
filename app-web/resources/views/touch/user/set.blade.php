<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/set')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/set')); ?>

@extends('layouts.touch')
@section('content')
    <div class="set-content">
        @include('partials.detail-header', array('title' => "设置",'type' =>""))
        <div class="set-box">
            <a href="javascript:;" class="change-password">修改密码<span>></span></a>
            <a href="javascript:;" class="about-us">关于<span>></span></a>
            <a href="{{route('user.logout')}}" class="loginout">退出登陆</a>
        </div>
        <div class="password-box" style="display: none;">
            <form id="form_creat" action="" class="creat-box" method="POST">
                <p class="first-top"><span>旧密码</span>
                    <input type="password" name="old_password" placeholder="点击输入" value="{{$old_password or ''}}"
                           data-pattern="^[0-9a-zA-z]{6,12}$"
                           data-required="true"
                           data-descriptions="oldPassword"
                           data-describedby="oldPassword-description">
                </p>
                <div id="oldPassword-description" class="error-tip"></div>

                <p>
                    <span>新密码</span>
                    <input type="password" name="new_password" placeholder="点击输入" value="{{$new_password or ''}}"
                           data-pattern="^[0-9a-zA-z]{6,12}$"
                           data-required="true"
                           data-descriptions="newPassword"
                           data-describedby="newPassword-description">
                </p>
                <div id="newPassword-description" class="error-tip"></div>
                <div class="hint-content"></div>
                <div class="save-box">
                    <input class="save-btn" type="submit" value="保存">
                </div>
            </form>
            <p class="suc-tip" style="display: none;">修改密码成功！</p>
        </div>
        <div class="about-box" style="display: none;">
            <img src="{!! isset($host) ? $host : ''!!}/image/logo.jpg">
            <p>销售管理工具V1.0</p>
        </div>
    </div>
@endsection