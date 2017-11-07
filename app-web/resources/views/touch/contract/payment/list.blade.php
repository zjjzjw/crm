<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/contract/payment/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/payment/list')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'contract_id' => $contract_id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <div class="list-header">
        <div class="header-box">
            <a id="com_back" class="com-back" href="javascript:history.back()">
                <i class="iconfont">&#xe624;</i>
            </a>
            <div class="choose-title">
                <span class="title">回款详情</span>
            </div>
            {{--添加按钮--}}
            <a href="JavaScript:;" class="add-btn pull-down"><i class="iconfont">&#xe637;</i></a>
            <div class="optionlist" id="optionlist" style="display: none;">
                <div class="payment-add">
                    <a href="{{route('contract.payment.edit',
                    [
                      'contract_id' => $contract_id ,
                      'type' => \Huifang\Src\Contract\Domain\Model\ContractPaymentType::TYPE_PLAN ,
                      'id' => 0
                     ]
                     )}}">
                        添加回款计划
                    </a>
                    <a href="{{route('contract.payment.edit',
                    [
                      'contract_id' => $contract_id ,
                      'type' => \Huifang\Src\Contract\Domain\Model\ContractPaymentType::TYPE_RECORD ,
                      'id' => 0
                    ])}}">
                        添加回款记录
                    </a>
                </div>
            </div>
        </div>
        <div id="dialog" style="display: none;"></div>
    </div>
    <!-- 回款详情列表页-->
    <div class="list-content">
        <div class="progress-bar">
            <p>总额<i>{{$contract_amount or 0}}元</i></p>
            <div class="bar">
                <div class="orang" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <div class="list-content">
        <div class="progress-bar">
            <p>回款数<i>{{$has_payment_amount or ''}}元</i></p>
            <div class="bar">
                @if($percent>100)
                    <div class="green" style="width: 100%;"></div>
                @else
                    <div class="green" style="width: {{$percent or 0}}%;"></div>
                @endif
            </div>
        </div>
    </div>

    @foreach($periods as $period)
        <div class="payment-plan">
            <h1>{{$period['name'] or ''}}</h1>
            <ul>
                @foreach($period['items'] as $item)
                    <li>
                        <a href="{{route('contract.payment.detail', ['contract_id' => $item['contract_id'], 'id' => $item['id']])}}">
                            @if($item['payment_type'] == \Huifang\Src\Contract\Domain\Model\ContractPaymentType::TYPE_PLAN)
                                <span class="plan">{{$item['payment_type_name'] or ''}}</span>
                            @else
                                <span class="records">{{$item['payment_type_name'] or ''}}</span>
                            @endif
                            <span>{{$item['payment_at'] or ''}}</span>
                            <span>{{$item['payment_amount'] or ''}}元</span>

                            @if($item['payment_type'] == \Huifang\Src\Contract\Domain\Model\ContractPaymentType::TYPE_PLAN)
                                @if($item['status'] == \Huifang\Src\Contract\Domain\Model\ContractPaymentStatus::FINISH)
                                    <span class="completed">{{$item['status_name'] or ''}}</span>
                                @else
                                    <span class="ongoing">{{$item['status_name'] or ''}}</span>
                                @endif
                            @endif
                            <i>></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@endsection