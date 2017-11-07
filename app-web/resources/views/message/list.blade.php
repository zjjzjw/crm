<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/message/list', 'css/ui/list/list-items')); ?>

@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', [
               'choose' => $choose,
    ])
    <div class="all-box">
        {{-- 列表 --}}
        <div class="list-items">
            <ul class="common-list">
                @foreach($user_messages as $user_message)
                    <li class="item-info">
                        <a href="{{route('message.detail', ['id' => $user_message['id']] )}}">
                            <p class="item-title">{{$user_message['title'] or ''}}</p>
                            <p class="time">{{$user_message['time'] or ''}}</p>
                            <span>></span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection