<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/company/edit')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/edit']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/partials/topmenu']); ?>

@extends('layouts.master')

@section('master.content')

    @if(!empty($id))
        @include('pages.company.partials.topmenu', ['company_id' => $id])
    @endif
    <div class="wrap-content">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <form id="form" action="{{route('company.store')}}" method="POST">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">公司名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="必填，长度最大50">

                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">生效时间：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" class="date" placeholder="" name="start_time"
                               value="{{$start_time or ''}}"
                               data-validation="date"
                               data-validation-length="yyyy-mm-dd"
                               data-validation-error-msg="必填，格式yyyy-mm-dd"

                        >
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">结束时间：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" class="date" placeholder="" name="end_time"
                               value="{{$end_time or ''}}"
                               data-validation="required date"
                               data-validation-length="yyyy-mm-dd"
                               data-validation-error-msg="必填，格式yyyy-mm-dd"
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">账号数量：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="user_number"
                               value="{{$user_number or ''}}"
                               data-validation="required custom"
                               data-validation-regexp="^[1-9]{1}\d*$"
                               data-validation-error-msg="必填，数字"
                        >
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
                                   data-validation="required"
                                   @if(($is_free ?? 0) == $key)
                                   checked
                                   @endif
                                   data-validation-error-msg="必填，是否免费"

                            >
                            <label for=" checkbox{{$key}}">{{$name}}</label>
                        @endforeach
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