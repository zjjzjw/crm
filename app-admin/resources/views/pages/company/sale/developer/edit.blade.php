<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/sale/developer/edit')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/developer/edit']); ?>
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
        [
                'id'          => $id ?? 0,
                'area'        => $areas ?? [],
                'province_id' => $province_id  ?? 0,
                'city_id'     => $city_id  ?? 0,
                'company_id'     => $company_id  ?? 0,

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
                        <label for="right-label" class="text-right">省/直辖市</label>
                    </div>
                    <div class="small-6 columns">
                        <select name="province_id" id="province_id"
                                data-validation="required"
                                data-validation-error-msg="请选择省/直辖市">
                            <option value="">--请选择--</option>
                        </select>
                    </div>

                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">城市</label>
                    </div>
                    <div class="small-6 columns">
                        <select name="city_id" id="city_id"
                                data-validation="required"
                                data-validation-error-msg="请选择城市">
                            <option value="">--请选择--</option>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">分公司名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入所属集团名称"      name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入所属集团名称，长度最大50">
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