<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/message/detail', 'css/ui/list/list-items')); ?>

@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', [
               'choose' => $choose,
    ])

    <div class="all-box">
        {{-- 列表 --}}
        <div class="detail-title">
            <p class="item-title">{{$title or ''}}</p>
            <p class="time">{{$time or ''}}</p>
        </div>

        <div class="detail-content">
            {{$info or ''}}
        </div>

    </div>
@endsection