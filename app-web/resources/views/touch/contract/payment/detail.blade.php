<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/contract/payment/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/payment/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'id'          => $id ?? 0,
        'contract_id' => $contract_id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => $title,
            'url' => route('contract.payment.edit', ['contract_id' => $contract_id , 'type' => $payment_type,  'id' => $id]),
            'type' => 1, //编辑和删除
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => 'contract.payment.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>计划回款金额</dt>
                <dd>{{$payment_amount or ''}}元</dd>
                <dt>计划回款日期</dt>
                <dd>{{$payment_at or ''}}</dd>
                <dt>备注</dt>
                <dd>{{$note or ''}}</dd>
            </dl>
        </div>
    </div>
    {{-- 删除--}}
    @include('partials.delete-pop')
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection