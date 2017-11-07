<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/payment-schedule-detail')); ?>

@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "回款详情",
            'url' => [],
            'type' => 0,
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => ''
        ])

        <div class="progress-bar">
            <h3 class="payment">回款进度</h3>
            <div class="bar">
                <div class="orang" style="width: {{$contract_data['percent'] ?? ''}}%"></div>
                <em>{{$contract_data['payment_amount'] ?? ''}}元(已回款)</em>
            </div>
            <p class="payment-money">{{$contract_data['total_amount'] ?? ''}}元</p>
        </div>
    </div>

@endsection