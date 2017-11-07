<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/product/sorts/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/product/sorts/list')); ?>

@extends('layouts.touch')
@section('content')
    @include('partials.detail-header', array('title' => "产品列表",'type' => 0 ))
    <div class="list-items">
        <div id="menu" class="menu">
            <div id="menuinfo">
                <div class="menunav" id="menunav">
                    <p id="mass" class="menunav-row">
                        <span class="parentup" data-type="0">产品分类</span><i class="g-touchicon-l revolve"></i>
                    </p>
                </div>
            </div>
        </div>

        <div class="optionlist" id="optionlist" style="display: none;">
            <div class="mass menunav-info" id="priceinfo" style="display: none;">
                <div class="pricelist auto-scoll">
                    <a rel="nofollow" class="@if(($appends['category_id'] ?? 0) == 0) active @endif"
                       href="{{route('product.sorts.list', array_merge($appends, ['category_id' => 0]))}}">全部</a>
                    @foreach($product_categories as $product_category)
                        <a rel="nofollow"
                           class="@if(($appends['category_id'] ?? 0) == $product_category['id']) active @endif"
                           href="{{route('product.sorts.list', array_merge($appends, ['category_id' => $product_category['id']]))}}">
                            {{$product_category['name']}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <ul class="company-list">
            @foreach($products as $product)
                <li>
                    <a href="{{route('product.detail', ['id' => $product['id']])}}">{{$product['name']}}
                        <span>></span></a>
                </li>
            @endforeach
        </ul>
        <div id="dialog" style="display: none;"></div>
    </div>
@endsection