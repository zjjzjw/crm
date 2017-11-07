<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/detail')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/detail']); ?>

@extends('layouts.master')

@section('master.content')
    <div class="wrap-content">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <div class="content">
            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">公司名称：</label>
                </div>
                <div class="small-18 columns">
                    {{$name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">生效时间：</label>
                </div>
                <div class="small-18 columns">
                    {{$start_time or ''}}
                </div>
            </div>
            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">结束时间：</label>
                </div>
                <div class="small-18 columns">
                    {{$end_time or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">账号数量：</label>
                </div>
                <div class="small-18 columns">
                    {{$user_number or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">是否免费：</label>
                </div>
                <div class="small-18 columns">
                    @foreach($free_types as $key => $name)
                        <input id="checkbox{{$key}}" name="is_free" type="radio"
                               value="{{$key}}"
                               @if(($is_free ?? 0) == $key)
                               checked
                               @endif
                               disabled
                        >
                        <label for="checkbox{{$key}}">{{$name}}</label>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
@endsection