<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/contract/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/edit')); ?>

<?php Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'id' => $id ?? 0,
        ]
);

?>
@extends('layouts.touch')
@section('content')
    <div class="edit-content">
        <!-- 创建-->
        @include('partials.detail-header', array('title' => $title ,'type' => 0))
        <form id="form_creat" action="" class="creat-box" method="POST">
            <p class="first-top">
                <span>合同编号</span>
                <input name="contract_number" placeholder="点击输入" maxlength="20"
                       value="{{$contract_number or ''}}"
                       data-required="true"
                       data-descriptions="contractnumber"
                       data-describedby="contractnumber-description"/>
            </p>
            <div id="contractnumber-description" class="error-tip"></div>

            <p>
                <span>合同名称</span>
                <input name="contract_name" placeholder="点击输入" maxlength="20"
                       value="{{$contract_name or ''}}"
                       data-required="true"
                       data-descriptions="contractname"
                       data-describedby="contractname-description"/>
            </p>
            <div id="contractname-description" class="error-tip"></div>

            <p>
                <span>合同签订日期</span>
                <input name="signed_at" placeholder="点击选择"
                       value="{{$signed_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="signed"
                       data-describedby="signed-description"/>
            </p>
            <div id="signed-description" class="error-tip"></div>

            <p>
                <span>客户名称</span>
                <input type="text"
                       value="{{$customer_name or ''}}"
                       name="customer_name"
                       data-required="true"
                       data-descriptions="customer"
                       data-describedby="customer-description"/>
            </p>
            <div id="customer-description" class="error-tip"></div>

            <p class="product-detail" style="@if(!empty($contract_products))display: none;@endif">
                <span>产品</span>
                <input class="add-product" name="product_name" placeholder="点击选择"
                       data-descriptions="productname"
                       data-describedby="productname-description"
                       data-conditional="confirmlength"
                       value=""/>
            </p>
            <div id="productname-description" class="error-tip"></div>

            <div class="product-list-box" style="@if(empty($contract_products))display: none;@endif">
                <div class="product-list-box-items">
                    @if(!empty($contract_products))
                        @foreach(!empty($contract_products) ? $contract_products : [''] as $contract_product)
                            <div class="box-item">
                                <p class="product-title">产品<i class="iconfont del-parameter-btn">&#xe621;</i></p>
                                <input type="hidden" name="products[product_id][]"
                                       value="{{$contract_product['product_id'] or ''}}">
                                <p class="product-name">{{$contract_product['name'] or ''}}</p>
                                <p class="product-num">数量：<span>{{$contract_product['product_number'] or ''}}</span></p>
                                <input type="hidden" name="products[product_number][]"
                                       value="{{$contract_product['product_number'] or ''}}">
                                <p class="product-per-price">
                                    产品单价：<span>{{$contract_product['product_price'] or ''}}</span>
                                    元
                                </p>
                                <input type="hidden" name="products[product_price][]"
                                       value="{{$contract_product['product_price'] or ''}}">
                            </div>
                        @endforeach
                    @endif
                </div>


                <div class="add-product-btn"
                     style="@if(!empty($contract_products) && (count($contract_products) >= 6))display: none; @endif ">
                    添加产品
                </div>

            </div>


            <div id="product-description" class="error-tip"></div>

            <p>
                <span>合同金额</span>
                <input name="contract_amount" placeholder="点击输入" maxlength="11"
                       value="{{$contract_amount or ''}}"
                       data-required="true"
                       data-pattern="^[0-9]+(.[0-9]{1,3})?$"
                       data-descriptions="contractamount"
                       data-describedby="contractamount-description"/>
                <em>元</em>
            </p>
            <div id="contractamount-description" class="error-tip"></div>

            <p>
                <span>首付款</span>
                <input name="down_payment" placeholder="点击输入" maxlength="11"
                       value="{{$down_payment or ''}}"
                       data-required="true"
                       data-pattern="^[0-9]+(.[0-9]{1,3})?$"
                       data-descriptions="downpayment"
                       data-describedby="downpayment-description"/>
                <em>元</em>
            </p>
            <div id="downpayment-description" class="error-tip"></div>

            <p>
                <span>预计回款日期</span>
                <input name="expected_return_at" placeholder="点击选择"
                       value="{{$expected_return_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="receivedpaymentst"
                       data-describedby="receivedpaymentst-description"/>
            </p>
            <div id="receivedpaymentst-description" class="error-tip"></div>

            <p>
                <span>尾款金额</span>
                <input name="tail_amount" placeholder="点击输入" maxlength="11"
                       value="{{$tail_amount or ''}}"
                       data-required="true"
                       data-pattern="^[0-9]+(.[0-9]{1,3})?$"
                       data-descriptions="partner"
                       data-describedby="partner-description"/>
                <em>元</em>
            </p>
            <div id="partner-description" class="error-tip"></div>

            <p>
                <span>尾款到账日期</span>
                <input name="tail_amount_at" placeholder="点击选择"
                       value="{{$tail_amount_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="tailamount"
                       data-describedby="tailamount-description"/>
            </p>
            <div id="tailamount-description" class="error-tip"></div>

            <p>
                <span>产品交付日期</span>
                <input name="product_delivery_at" placeholder="点击选择"
                       value="{{$product_delivery_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="deliverydate"
                       data-describedby="deliverydate-description"/>
            </p>
            <div id="deliverydate-description" class="error-tip"></div>


            <div class="save-box">
                <input name="id" type="hidden" value="{{$id or 0}}"/>
                @if(!empty($id))
                    <input class="save-btn" type="submit" value="保存"/>
                @else
                    <input class="save-btn" type="submit" value="创建"/>
                @endif
            </div>
        </form>
    </div>
    <div class="add-box" style="display: none;">
        @include('partials.edit-header', array('title' => "产品选择"))
        <p>
            <span>产品</span>
            <select id="select-product" class="select-product" name="product_id">
                <option class="default-value" value="">--请选择--</option>
                @foreach($select_products as $select_product)
                    <option class="product-id" data-name="{{$select_product['name']}}" value="{{$select_product['id']}}"
                    >{{$select_product['name']}}</option>
                @endforeach
            </select>
        </p>
        <div class="id-description error-tip"></div>

        <p>
            <span>数量</span>
            <input class="product-number" name="product_number" placeholder="点击输入" maxlength="5"
                   value=""/>
        </p>
        <div class="number-description error-tip"></div>

        <p>
            <span>产品单价</span>
            <input class="product-price" name="product_price" placeholder="点击输入" maxlength="11" value=""/>
            <em>元</em>
        </p>
        <div class="price-description error-tip"></div>
        <input class="add-save-btn" type="submit" value="确定"/>
    </div>

    <script type="text/html" id="product_tpl">
        <div class="box-item">
            <p class="product-title">产品<i class="iconfont del-parameter-btn">&#xe621;</i></p>
            <input type="hidden" name="products[product_id][]"
                   value="<%=result.product_id%>">
            <p class="product-name"><%=result.name%></p>
            <p class="product-num">数量：<span><%=result.num%></span></p>
              <input type="hidden" name="products[product_number][]"
                                       value="<%=result.num%>">
            <p class="product-per-price">产品单价：<span><%=result.price%></span> 元</p>
              <input type="hidden" name="products[product_price][]"
                                       value="<%=result.price%>">
        </div>
    </script>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection