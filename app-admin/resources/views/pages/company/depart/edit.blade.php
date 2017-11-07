<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/depart/edit')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/depart/edit']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>

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

        <form id="form" action="{{route('company.depart.store')}}"
              method="POST">
            <div class="content">
                <input type="text" placeholder="输入企业部门名称" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="必填，长度最大50">

            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="hidden" name="parent_id" value="{{$parent_id ?? 0}}">
                <input type="submit" class="button" value="确定">
            </div>
        </form>
    </div>
@endsection