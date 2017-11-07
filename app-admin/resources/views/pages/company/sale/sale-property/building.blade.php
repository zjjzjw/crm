<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/building','css/lib/autocomplete/autocomplete']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/building']); ?>

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
                        <label for="right-label" class="text-right">开发商</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入开发商" name="developer_name"
                               value="{{$developer_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入开发商">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">精装总户数</label>
                    </div>
                    <div class="small-6 columns unit">
                        <input type="text" placeholder="请输入精装总户数" name="house_total"
                               value="{{$house_total or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入精装总户数">
                        <em>户</em>
                    </div>
                    <div class="small-4 columns">
                        <label for="right-label" class="text-right">装修类别</label>
                    </div>
                    <div class="small-8 columns unit">
                        <select name="decoration_type" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择装修类别">
                            <option value="">--请选择--</option>
                            @foreach($decoration_types as $key => $name)
                                <option value="{{$key}}"
                                        @if(($decoration_type ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">精装标准(元/m2)</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入精装标准(元/m2)" name="hardcover_standard"
                               value="{{$hardcover_standard or 0}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入精装标准(元/m2)">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">当期精装户数</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入当期精装户数" name="at_hardcover_house_total"
                               value="{{$at_hardcover_house_total or 0}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入当期精装户数">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">楼层状况</label>
                    </div>
                    <div class="small-18 columns textarea">
                        <textarea name="floor_condition" id=""
                                  data-validation="required length"
                                  data-validation-length="max50"
                                  data-validation-error-msg="请输入产楼层状况">{{$floor_condition or ''}}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">楼栋总数</label>
                    </div>
                    <div class="small-6 columns unit">
                        <input type="text" placeholder="请输入楼栋总数" name="floor_total"
                               value="{{$floor_total or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入楼栋总数">
                        <em>栋</em>
                    </div>
                    <div class="small-4 columns">
                        <label for="right-label" class="text-right">占地面积</label>
                    </div>
                    <div class="small-8 columns unit">
                        <input type="text" placeholder="请输入占地面积" name="area_covered"
                               value="{{$area_covered or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入占地面积">
                        <em>平方米</em>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">工程进度</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="project_schedule" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择工程进度">
                            <option value="">--请选择--</option>
                            @foreach($project_schedules as $key => $name)
                                <option value="{{$key}}"
                                        @if(($project_schedule ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">建筑面积</label>
                    </div>
                    <div class="small-18 columns unit">
                        <input type="text" placeholder="请输入建筑面积" name="architecture_covered"
                               value="{{$architecture_covered or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入建筑面积">
                               <em>平方米</em>
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