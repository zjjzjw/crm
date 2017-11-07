<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/property']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/property']); ?>

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
                        <label for="right-label" class="text-right">物业类型</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="property_type" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择物业类型">
                            <option value="">--请选择--</option>
                            @foreach($property_types as $key => $name)
                                <option value="{{$key}}"
                                        @if(($property_type ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">物业公司</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入物业公司" name="property_company" maxlength="200"
                               value="{{$property_company or ''}}"
                               data-validation="required length"
                               data-validation-length="max200"
                               data-validation-error-msg="请输入物业公司"/>
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