<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/product/detail')); ?>
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
            'title' => "产品详情",
            'type' => 0
        ])
        <div class="detail-box">
            <dl>
                <dt>产品归属</dt>
                <dd>{{$company_name or ''}}</dd>
                <dt>产品分类</dt>
                <dd>{{$category_name or ''}}</dd>
                <dt>产品名</dt>
                <dd>{{$name or ''}}</dd>
                <dt>价格(元)</dt>
                <dd>{{$price or ''}}</dd>
                <dt>产品图</dt>
                <dd>
                    @foreach($product_images as $product_image)
                        <img src="{{$product_image['url']}}?imageView2/2/w/400" alt="">
                    @endforeach
                </dd>
            </dl>
            <div class="parameters">
                <h3>产品参数</h3>
                <ul>
                    @foreach($params ?? []as $param)
                        <li>
                            <span>{{$param['name'] or ''}}</span>
                            <span>{{$param['value'] or ''}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection