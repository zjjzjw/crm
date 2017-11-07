<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/rival/edit']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/rival/edit']); ?>

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

        <form id="form" action="{{route('company.rival.store')}}"
              method="POST">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">竞品公司名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="必填，长度最大50">
                    </div>
                </div>

            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="hidden" name="company_id" value="{{$company_id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
@endsection