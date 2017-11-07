<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/product/company/list')); ?>

@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.detail-header', array('title' => "公司列表",'type' => 0 ))
    <div class="list-items">
        <ul class="company-list">
            @foreach($companies as $company)
                <li>
                    <a href="{{route('product.sorts.list', ['company_id' => $company['id'], 'type' => $company['type']])}}">
                        {{$company['name']}}<span>></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection