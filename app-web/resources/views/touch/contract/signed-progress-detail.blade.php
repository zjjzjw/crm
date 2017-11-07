<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/signed-progress-detail')); ?>

@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "签单详情",
            'url' => [],
            'type' => 0,
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => ''
        ])

        <div class="progress-bar">
            <h3 class="payment">进度</h3>
            <div class="bar">
                <div class="green" style="width: {{$contract_data['percent'] or 0}}%"></div>
                <em>{{$contract_data['contract_amount'] or 0}}元(已签约)</em>
            </div>
            <p class="payment-money">{{$contract_data['sign_task_amount'] or 0}}元</p>
        </div>
    </div>
@endsection