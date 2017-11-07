<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/sign-task/distribution')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/sign-task/distribution')); ?>

@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.list-header', ['choose'=> ['title' => "任务分配"]])
        <ul class="list-box">
            @foreach($depart_users as $depart_user)
                @if(count($depart_user['users'] ?? []) > 0)
                    <li>
                        <p class="name">{{$depart_user['name'] or ''}}（{{count($depart_user['users'])}}）
                            <i class="iconfont">&#xe624;</i></p>
                        <ul class="sign-task">
                            @foreach($depart_user['users'] as $user)
                                <li>
                                    <a href="{{route('user.sign-task.list',['id'=> $user['id']])}}">
                                        {{$user['name']}}<span>></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endsection