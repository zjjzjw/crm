<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/help/detail')); ?>

@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "帮助中心",
            'type' => 0
        ])
        <div class="detail-box">
            @if($type ==1)
                <p class="detail-title">名片夹</p>
                <ol>
                    <li>
                        <p class="detail-info">名片录入页面中，创建的名片</p>
                    </li>
                </ol>
            @endif
        </div>
    </div>
@endsection