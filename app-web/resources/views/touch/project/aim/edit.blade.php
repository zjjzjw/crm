<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/aim/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/edit')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id ?? 0,
        'id'         => $id ?? 0
]);
?>
@extends('layouts.touch')
@section('content')
    <div class="edit-content">
        <!-- 创建-->
        @include('partials.detail-header', array('title' => "创建目标",'type' => 0))
        <form id="form_creat" action="" class="creat-box" method="POST">
            <p class="first-top"><span>目标名称</span>
                <input name="name" placeholder="点击输入" value="{{$name or ''}}" maxlength="20"
                       data-required="true"
                       data-descriptions="name"
                       data-describedby="name-description">
            </p>
            <div id="name-description" class="error-tip"></div>

            <p class="product-detail" style="@if(!empty($project_aim_products))display: none;@endif">
                <span>产品</span>
                <input class="add-product" name="product_name" placeholder="点击选择"
                       data-descriptions="productname"
                       data-describedby="productname-description"
                       data-conditional="confirmlength"
                       value=""/>
            </p>
            <div id="productname-description" class="error-tip"></div>

            <div class="product-list-box" style="@if(empty($project_aim_products))display: none;@endif">
                <div class="product-list-box-items">
                    @if(!empty($project_aim_products))
                        @foreach(!empty($project_aim_products) ? $project_aim_products : [''] as $project_aim_product)
                            <div class="box-item">
                                <p class="product-title">产品<i class="iconfont del-parameter-btn">&#xe621;</i></p>
                                <input type="hidden" name="products[product_id][]"
                                       value="{{$project_aim_product['product_id'] or ''}}">
                                <p class="product-name">{{$project_aim_product['name'] or ''}}</p>
                                <p class="product-per-price">
                                    价格：<span>{{$project_aim_product['price'] or ''}}</span>
                                    元
                                </p>
                                <input type="hidden" name="products[price][]"
                                       value="{{$project_aim_product['price'] or ''}}">
                                <p class="product-num">数量：<span>{{$project_aim_product['volume'] or ''}}</span>
                                </p>
                                <input type="hidden" name="products[volume][]"
                                       value="{{$project_aim_product['volume'] or ''}}">
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="add-product-btn"
                     style="@if(!empty($project_aim_products) && (count($project_aim_products) >= 6)) display: none; @endif ">
                    添加产品
                </div>
            </div>
            <div id="product-description" class="error-tip"></div>

            <p>
                <span>痛点分析</span>
                <input name="pain_analysis" placeholder="点击输入" value="{{$pain_analysis or ''}}" maxlength="30"
                       data-required="true"
                       data-descriptions="pain"
                       data-describedby="pain-description">
            </p>
            <div id="pain-description" class="error-tip"></div>


            <p><span>其他</span>
                <input name="other" placeholder="点击输入" value="{{$other or ''}}" maxlength="500">
            </p>

            <div class="save-box">
                <input name="project_id" type="hidden" value="{{$project_id or 0}}">
                <input name="id" type="hidden" value="{{$id or 0}}">
                @if(!empty($id))
                    <input class="save-btn" type="submit" value="保存">
                @else
                    <input class="save-btn" type="submit" value="创建">
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
                @if(!empty($select_products))
                    @foreach($select_products as $select_product)
                        <option class="product-id" data-name="{{$select_product['name']}}"
                                value="{{$select_product['id']}}"
                        >{{$select_product['name']}}</option>
                    @endforeach
                @endif
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
            <span>价格</span>
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
            <p class="product-per-price">价格：<span><%=result.price%></span> 元</p>
              <input type="hidden" name="products[price][]"
                                       value="<%=result.price%>">
            <p class="product-num">数量：<span><%=result.num%></span></p>
              <input type="hidden" name="products[volume][]"
                                       value="<%=result.num%>">
        </div>
    </script>
    {{--权限提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection