<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/sign-task/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/sign-task/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'id'      => $id ?? 0,
                'user_id' => $user_id ?? 0,
        ]
); ?>

@extends('layouts.touch')

@section('content')
    <div class="edit-content">
        <!-- 创建-->
        @include('partials.detail-header', array('title' => $title ,'type' => 0))
        <form id="form_creat" action="" class="creat-box" method="POST">

            <p><span>签单任务月份</span>
                <select class="month" name="month"
                        data-required="true"
                        data-descriptions="time"
                        data-describedby="time-description">
                    <option value="">--请选择--</option>
                    @foreach($months as $key =>  $name)
                        <option value="{{$key}}" @if(($month ?? 0) == $key) selected @endif>{{$name}}</option>
                    @endforeach
                </select>
            </p>
            <div id="time-description" class="error-tip"></div>

            <p>
                <span>签订任务金额</span>
                <input class="address" name="amount" placeholder="点击输入"
                       value="{{$amount or ''}}" maxlength="30"
                       data-required="true"
                       data-descriptions="amount"
                       data-describedby="amount-description">
            </p>

            <div id="amount-description" class="error-tip"></div>

            <div class="save-box">
                <input type="hidden" name="user_id" value="{{$user_id}}"/>
                <input name="id" type="hidden" value="{{$id or 0}}">
                @if(!empty($id))`
                <input class="save-btn" type="submit" value="保存">
                @else
                    <input class="save-btn" type="submit" value="创建">
                @endif
            </div>
        </form>
    </div>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection