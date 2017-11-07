<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/developer-group/edit']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/developer-group/edit']); ?>
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
    [
        'id'          => $id ?? 0
    ]
)
?>
@extends('layouts.master')

@section('master.content')

    <div class="wrap-content">

        <form id="form" onsubmit="return false">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">所属集团名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入所属集团名称" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入所属集团名称，长度最大50">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}" class="hidden-input">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
    @include('pages.common.loading-pop')
    @include('pages.common.success-pop')
    @include('pages.common.prompt-pop',['type'=>1])
    @include('pages.common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection
