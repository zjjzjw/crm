<?php Huifang\Admin\Http\Controllers\Resource::addJS([('app/company/user/pwd')]); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/user/pwd']); ?>

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

        <form id="form" method="post" action="{{route('company.user.pwd.store')}}">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">新密码：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="password" placeholder="6-12位，字母数字组合" name="password" maxlength="12"
                               data-validation="required password"
                               data-validation-error-msg="请输入新密码，应为6-12位数字或字母组合">
                    </div>
                    <div id="password-description" class="error-tip"></div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">确认新密码：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="password" placeholder="6-12位，字母数字组合" name="confirm_password" maxlength="12"
                               data-validation="required password"
                               data-validation-error-msg="请确认新密码，应为6-12位数字或字母组合">
                    </div>
                    <div id="confirmpassword-description" class="error-tip"></div>
                </div>
            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
@endsection