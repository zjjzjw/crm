<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/task-manifest')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/task-manifest')); ?>

@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.list-header', [
               'choose' => $choose
        ])

        <ul class="list-box">
            @foreach($depart_users as $depart_user)
                @if(count($depart_user['users'] ?? []) > 0)
                    <li>
                        <p class="name">{{$depart_user['name'] or ''}}（{{count($depart_user['users'])}}）
                            <i class="iconfont">&#xe624;</i></p>
                        <ul class="sign-task">
                            @foreach($depart_user['users'] as $item_user)
                                <li>
                                    <a href="{{route('project.task-manifest-list',['user_id'=> $item_user['id']])}}">
                                        {{$item_user['name']}}<span>></span>
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