<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/suggestion/edit')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/suggestion/edit']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>

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

        <form id="form" action="" method="POST">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">公司名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="company"
                               value="{{$company_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max30"
                               data-validation-error-msg="必填，长度最大30">

                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">联系方式：</label>
                    </div>
                    <div class="small-18 columns">
                        <input class="tel" type="text" placeholder="" name="phone" maxlength="11"
                               value="{{$user_info['phone'] or ''}}"
                               data-validation="required length phone"
                               data-validation-length="max11"
                               data-validation-error-msg="请输入正确手机号">
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">姓名：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max10"
                               data-validation-error-msg="必填，长度最大10">

                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">反馈时间：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" class="date" placeholder="" name="suggestion_time"
                               value="{{$suggestion_time or ''}}"
                               data-validation="date"
                               data-validation-length="yyyy-mm-dd"
                               data-validation-error-msg="必填，格式yyyy-mm-dd">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">反馈内容：</label>
                    </div>
                    <div class="small-18 columns text">
                        <textarea type="text" placeholder="" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="必填，长度最大50"></textarea>

                    </div>
                </div>

            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
@endsection