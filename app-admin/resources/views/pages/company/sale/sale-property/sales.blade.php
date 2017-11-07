<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/sales', 'css/lib/autocomplete/autocomplete', 'css/lib/datetimepicker/jquery.datetimepicker']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/sales']); ?>

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
                        <label for="right-label" class="text-right">楼盘均价(元/m2)</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入楼盘均价(元/m2)" name="housing_price"
                               value="{{$housing_price or ''}}"
                               data-validation="required length"
                               data-validation-length="max200"
                               data-validation-error-msg="请输入楼盘均价(元/m2)"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">是否有样板房</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="has_sample_house" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择是否有样板房">
                            <option value="">--请选择--</option>
                            @foreach($has_sample_houses as $key => $name)
                                <option value="{{$key}}"
                                        @if(($has_sample_house ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">样板房配套品牌</label>
                    </div>
                    <div class="small-18 columns content-style">
                        <input type="text" placeholder="请输入样板房配套品牌" name=""
                               value="{{$brand_name or ''}}"
                               id="keyword"
                               data_id="brand_id"
                               data-validation="required length"
                               data-validation-length="max200"
                               data-validation-error-msg="请输入样板房配套品牌"/>
                        <input type="hidden" name="brand_id" value="{{$brand_id or 0}}">
                        <div class="content-wrap"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">开盘时间</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入开盘时间" name="opening_time"
                               value="{{$opening_time or ''}}"
                               data-validation="required length"
                               data-validation-length="max200"
                               data-validation-error-msg="请输入开盘时间"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">交房时间</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入交房时间" name="handing_time"
                               value="{{$handing_time or ''}}"
                               data-validation="required length"
                               data-validation-length="max200"
                               data-validation-error-msg="请输入交房时间"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">售楼电话</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入售楼电话" name="sale_phone"
                               value="{{$sale_phone or ''}}"
                               data-validation="required length"
                               data-validation-length="max200"
                               data-validation-error-msg="请输入售楼电话"/>
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