<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/essential', 'css/lib/autocomplete/autocomplete']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/essential']); ?>
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
    [
        'id'          => $id ?? 0,
        'areas'       => $areas ?? [],
        'province_id' => $province_id ?? 0,
        'city_id'     => $city_id ?? 0,
        'county_id'   => $county_id ?? 0
    ]
)
?>
@extends('layouts.master')

@section('master.content')
    @include('pages.company.sale.sale-property.nav')
    <div class="wrap-content">
        <form id="form" onsubmit="return false">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">编号</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入编号" name="sn"
                               value="{{$sn or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入编号">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目名称</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入项目名称" name="project_name"
                               value="{{$project_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入产楼盘名称">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">楼盘名称</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入楼盘名称" name="loupan_name"
                               value="{{$loupan_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入产楼盘名称">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">省/直辖市</label>
                    </div>
                    <div class="small-4 columns">
                        <select name="province_id" id="province_id"
                                data-validation="required"
                                data-validation-error-msg="请选择省/直辖市">
                            <option value="">--请选择--</option>
                        </select>
                    </div>

                    <div class="small-2 columns">
                        <label for="right-label" class="text-right">城市</label>
                    </div>
                    <div class="small-4 columns">
                        <select name="city_id" id="city_id"
                                data-validation="required"
                                data-validation-error-msg="请选择城市">
                            <option value="">--请选择--</option>
                        </select>
                    </div>

                    <div class="small-2 columns">
                        <label for="right-label" class="text-right">区/县</label>
                    </div>
                    <div class="small-6 columns">
                        <select name="county_id" id="county_id"
                                data-validation="required"
                                data-validation-error-msg="请选择区/县">
                            <option value="">--请选择--</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">详细地址</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入详细地址" name="address"
                               value="{{$address or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入详细地址">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">分公司</label>
                    </div>
                    <div class="small-18 columns content-style">
                        <input type="text" name="name" value="{{$developer_property_name or ''}}"
                               data-id="{{$developer_id or 0}}"
                               id="keyword"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入分公司"/>
                        <input type="hidden" name="developer_id" value="{{$developer_id or 0}}">
                        <div class="content-wrap"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">工程大区划分</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="project_region_id" id="project_region_id"
                                data-validation="required"
                                data-validation-error-msg="请选择工程大区划分">
                            <option value="">--请选择--</option>
                            @foreach($large_areas as $large_area)
                                <option value="{{$large_area['id']}}"
                                        @if(($project_region_id ?? 0) == $large_area['id']) selected @endif
                                >{{$large_area['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目实际跟进人</label>
                    </div>
                    <div class="small-18 columns content-style-second">
                        <input type="text" placeholder="请输入项目实际跟进人" name="project_follow_people"
                               value="{{$user_name or ""}}"
                               data_id="{{$user_id or 0}}"
                               class="project-keyword"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入项目实际跟进人">
                        <input type="hidden" name="user_id" value="{{$user_id or 0}}">
                        <div class="project-content-wrap"></div>

                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">销售状态</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="sale_status" id="sale_status"
                                data-validation="required"
                                data-validation-error-msg="请选择销售状态">
                            <option value="">--请选择--</option>
                            @foreach($selling_status as $key => $name)
                                <option value="{{$key}}"
                                        @if(($sale_status ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
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