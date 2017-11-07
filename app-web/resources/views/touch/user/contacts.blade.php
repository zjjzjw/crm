<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/contacts')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/contacts')); ?>
@extends('layouts.touch')
@section('content')
    <div class="contacts-content">
        @include('partials.detail-header', array('title' => "通讯录",'type' => 0))
        <ul class="contacts-box">
            @foreach($depart_users as $depart_user)
                @if(!empty($depart_user['users']))
                    <li class="department">
                        <p class="name">
                            {{$depart_user['name'] or ''}}（{{count($depart_user['users'])}}）
                            <i class="iconfont">&#xe624;</i>
                        </p>
                        <ul class="department-people" style="display: none;">
                            @foreach($depart_user['users'] as $user)
                                <li>
                                    <a href="{{route('user.contacts.detail', ['id' => $user['id']])}}">
                                        {{$user['name'] or  ''}}<span>{{$user['role_name'] or ''}}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endsection