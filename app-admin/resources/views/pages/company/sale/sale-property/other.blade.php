<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/other']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/other']); ?>

@extends('layouts.master')
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
    [
        'id' => $id ?? 0
    ]
)
?>
@section('master.content')
    @include('pages.company.sale.sale-property.nav')
    <div class="wrap-content">
        <form id="form" action="" method="POST">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">备注</label>
                    </div>
                    <div class="small-18 columns textarea">
                        <textarea name="remake" id=""
                                  data-validation="required length"
                                  data-validation-length="max50"
                                  data-validation-error-msg="请输入备注">{{$remake or ''}}</textarea>
                    </div>
                </div>

            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
    @include('pages.common.loading-pop')
    @include('pages.common.success-pop')
    @include('pages.common.prompt-pop',['type'=>1])
    @include('pages.common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection