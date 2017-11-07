<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/approval/hinder/detail-aim')); ?>
@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header',['title' => "目标详情",'type' => 0 ])
        <div class="detail-box">
            <dl>
                <dt>目标名称</dt>
                <dd>{{$name or ''}}</dd>
                <dt>产品</dt>
                <dd>{{implode(',', $product_names ?? [])}}</dd>
                <dt>价格</dt>
                <dd>{{$price or ''}}</dd>
                <dt>体量</dt>
                <dd>{{$volume or ''}}</dd>
                <dt>痛点分析</dt>
                <dd>{{$pain_analysis or ''}}</dd>
                <dt>其他</dt>
                <dd>{{!empty($other) ? $other : '无'}}</dd>
            </dl>
        </div>
    </div>
@endsection