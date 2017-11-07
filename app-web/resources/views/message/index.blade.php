<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/message/index')); ?>
@extends('layouts.touch')
@section('content')


    <!-- 编辑-->
    <div class="list-content">
        {{-- 头部title --}}
        @include('partials.list-header', [
                'choose' => $choose,
        ])
        <ul class="list-box">
            @foreach($msg_types as $msg_type)
                <li>
                    <a href=" {{route('message.list', ['type' => $msg_type['id']])}}">
                        <p>
                            <i class="iconfont information">&#xe606;</i>{{$msg_type['name'] or ''}}
                        </p>
                        <span class="message">{{$msg_type['total']}}
                            @if(!empty($msg_type['unread_count']))
                                <em>{{$msg_type['unread_count']}}</em>
                                <i class="arrow-down"></i>
                            @endif
                            <span>></span>
                    </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

@endsection