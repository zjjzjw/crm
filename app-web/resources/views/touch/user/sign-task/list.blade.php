<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/sign-task/list')); ?>
@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.list-header', [
               'choose' => $choose,
               'add_permission' => 'sale.add',
        ])
        <ul class="list-box">
            @foreach($sign_tasks as $sign_task)
                <li>
                    <a href="{{route('user.sign-task.detail',['id' => $sign_task['id']])}}">
                        {{$sign_task['format_month']}}<span>></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection