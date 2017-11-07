<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/sign-task/detail')); ?>

@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "任务详情",
            'url' => route('user.sign-task.edit', ['id' => $id ?? 0 , 'user_id' => $user_id]),
            'type' => 1, //编辑和删除
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => 'contract.view.edit',
            'delete_un_visible' => true
        ])
        <div class="detail-box">
            <dl>
                <dt>签单任务时间</dt>
                <dd>{{format_ym($month)}}</dd>
                <dt>签单任务金额</dt>
                <dd>{{$amount or ''}}元</dd>
            </dl>
        </div>
    </div>
@endsection