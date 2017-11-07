<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/contract/payment/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/payment/edit', 'css/ui/detail/detail-header')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/payment/edit', 'css/ui/detail/detail-header')); ?>

<?php Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'id'          => $id ?? 0,
                'type'        => $type ?? 0,
                'contract_id' => $contract_id ?? 0,
        ]
); ?>

@extends('layouts.touch')

@section('content')
    <div class="edit-content">
        <!-- 创建-->
        @include('partials.detail-header', array('title' => $title ,'type' => 0))
        <form id="form_creat" action="" class="creat-box" method="POST">
            <p class="periods first-top">
                <span>第</span>
                <select name="period"
                        data-required="true"
                        data-descriptions="period"
                        data-describedby="period-description">

                    <option value="">--请选择--</option>
                    @foreach($periods as $period_item)
                        <option value="{{$period_item['id']}}"
                                @if(($period ?? 0) == $period_item['id'])
                                selected
                                @endif
                        >{{$period_item['name']}}</option>
                    @endforeach
                </select>
                <span>期</span>
            </p>
            <div id="period-description" class="error-tip"></div>

            <p>
                <span>{{$title_name}}金额</span>
                <input name="payment_amount" placeholder="点击输入" maxlength="11"
                       value="{{$payment_amount or ''}}"
                       data-required="true"
                       data-pattern="^[0-9]+(.[0-9]{1,3})?$"
                       data-descriptions="paymentamount"
                       data-describedby="paymentamount-description"/>
                <em>元</em>
            </p>
            <div id="paymentamount-description" class="error-tip"></div>


            <p>
                <span>{{$title_name}}日期</span>
                <input name="payment_at" placeholder="点击选择"
                       value="{{$payment_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="paymentdate"
                       data-describedby="paymentdate-description"/>
            </p>
            <div id="paymentdate-description" class="error-tip"></div>

            <p>
                <span>备注</span>
                <input class="add-partner" name="note" placeholder="点击输入" maxlength="40"
                       value="{{$note or ''}}"
                       data-required="true"
                       data-descriptions="remarks"
                       data-describedby="remarks-description"/>
            </p>

            <div id="remarks-description" class="error-tip"></div>

            <div class="save-box">
                <input type="hidden" name="payment_type" value="{{$type ?? 0}}">
                <input type="hidden" name="contract_id" value="{{$contract_id ?? 0}}"/>
                <input type="hidden" name="id" value="{{$id ?? 0}}"/>
                @if(!empty($id))
                    <input class="save-btn" type="submit" value="保存"/>
                @else
                    <input class="save-btn" type="submit" value="创建"/>
                @endif
            </div>
        </form>
    </div>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection