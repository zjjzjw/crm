<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/card/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/card/edit')); ?>
@extends('layouts.touch')
@section('content')
    <!-- 创建-->
    @include('partials.detail-header', array('title' => "名片录入",'type' => 0))
    <form id="form_creat" action="" class="creat-box" method="POST">
        <p class="first-top"><span>姓名</span>
            <input name="name" placeholder="点击输入" value="{{$name or ''}}" maxlength="10"
                   data-required="true"
                   data-descriptions="name"
                   data-describedby="name-description">
        </p>
        <div id="name-description" class="error-tip"></div>

        <p>
            <span>手机</span>
            <input name="phone" placeholder="点击输入" value="{{$phone or ''}}" maxlength="11"
                   data-pattern="^1\d{10}$"
                   data-required="true"
                   data-descriptions="phone"
                   data-describedby="phone-description">
        </p>
        <div id="phone-description" class="error-tip"></div>

        <p>
            <span>电话</span>
            <input name="tel" placeholder="点击输入" value="{{$tel or ''}}" maxlength="15"
                   data-descriptions="tel"
                   data-describedby="tel-description">
        </p>

        <p>
            <span>邮件</span>
            <input name="email" placeholder="点击输入" value="{{$email or ''}}" maxlength="40"
                   data-pattern="\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}"
                   data-descriptions="mail"
                   data-describedby="mail-description">
        </p>
        <div id="mail-description" class="error-tip"></div>

        <p>
            <span>职位</span>
            <input name="position_name" placeholder="点击输入" value="{{$position_name or ''}}" maxlength="10"
                   data-required="true"
                   data-descriptions="job"
                   data-describedby="job-description">
        </p>
        <div id="job-description" class="error-tip"></div>

        <p>
            <span>公司</span>
            <input name="company_name" placeholder="点击输入" value="{{$company_name or ''}}" maxlength="20"
                   data-required="true"
                   data-descriptions="company"
                   data-describedby="company-description">
        </p>
        <div id="company-description" class="error-tip"></div>

        <p>
            <span>地址</span>
            <input name="address" placeholder="点击输入" value="{{$address or ''}}" maxlength="30"
                   data-required="true"
                   data-descriptions="address"
                   data-describedby="address-description">
        </p>
        <div id="address-description" class="error-tip"></div>

        <p>
            <span>邮编</span>
            <input name="zip_code" placeholder="点击输入" value="{{$zip_code or ''}}" maxlength="8"
                   data-descriptions="postcode"
                   data-describedby="postcode-description">
        </p>

        <div class="save-box">
            <input name="id" type="hidden" value="{{$id or 0}}">
            @if(!empty($id))
                <input class="save-btn" type="submit" value="保存">
            @else
                <input class="save-btn" type="submit" value="创建">
            @endif
        </div>
    </form>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection