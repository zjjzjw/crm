<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/home')); ?>
@extends('layouts.touch')
@section('content')
    <div class="top-title">
        <a id="com_back" class="com-back" href="javascript:history.back()">
            <i class="iconfont">&#xe624;</i>
        </a>
        <span class="company-name">{{$user->company->name ?? '公司名名'}}</span>
    </div>
    @if (count($errors) > 0)
        <div class="alert-box alert">
            @foreach ($errors as $key => $error)
                {{ $key . '、' . $error[0] }}
            @endforeach
        </div>
    @endif
@endsection