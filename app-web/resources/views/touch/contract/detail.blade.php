<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/contract/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'id' => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "合同详情",
            'url' => route('contract.edit', ['id' => $id]),
            'type' => 1, //编辑和删除
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => 'contract.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>合同编号</dt>
                <dd>{{$contract_number or ''}}</dd>
                <dt>合同名称</dt>
                <dd>{{$contract_name or ''}}</dd>
                <dt>合同签订日期</dt>
                <dd>{{$signed_at or ''}}</dd>
                <dt>客户名称</dt>
                <dd>{{$customer_name or ''}}</dd>
                @if(!empty($contract_products))
                    @foreach($contract_products as $contract_product)
                        <div>
                            <p class="describe">产品</p>
                            <p>{{$contract_product['name'] or ''}}</p>
                            <p class="describe">数量</p>
                            <p>{{$contract_product['product_number'] or ''}}</p>
                            <p class="describe">产品单价</p>
                            <p>{{$contract_product['product_price'] or ''}}</p>
                        </div>
                    @endforeach
                @else
                    <dt>产品</dt>
                    <dd>无</dd>
                @endif
                <dt>合同金额</dt>
                <dd>{{$contract_amount or ''}}元</dd>
                <dt>首付款</dt>
                <dd>{{$down_payment or ''}}元</dd>
                <dt>预计回款日期</dt>
                <dd>{{$expected_return_at or ''}}</dd>
                <dt>尾款金额</dt>
                <dd>{{$tail_amount  or ''}}元</dd>
                <dt>尾款到账日期</dt>
                <dd>{{$tail_amount_at or ''}}</dd>
                <dt>产品到账日期</dt>
                <dd>{{$product_delivery_at or ''}}</dd>
            </dl>
            <a href="{{route('contract.payment.list',['contract_id' => $id])}}">回款<span>></span></a>
        </div>
    </div>
    {{-- 删除--}}
    @include('../../partials.delete-pop')
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection