<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/opinion')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/opinion')); ?>
@extends('layouts.touch')
@section('content')
    <div class="opinion-content">
        @include('partials.detail-header', array('title' => "意见反馈",'type' =>"2"))
        <form id="opinion" class="opinian-box">
            <textarea name="content" maxlength="50" placeholder="请输入反馈内容.."></textarea>
            <p class="error-tip"></p>
            <p class="contact">联系方式<span>{{$phone or ''}}</span></p>
        </form>
        <p class="suc-tip" style="display: none;">反馈成功，感谢您的宝贵意见！</p>
    </div>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection
