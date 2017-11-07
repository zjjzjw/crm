<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale/edit']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale/edit']); ?>
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
    [
        'area'          => $areas ?? [],
        'province_id'   => $province_id ?? [],
        'city_id'       => $city_id ?? [],
        'county_id'     => $county_id ?? 0
    ]
)
?>
@extends('layouts.master')

@section('master.content')

    <div class="wrap-content">


        <form id="form" action="{{route('company.sale.sale.store')}}" method="POST">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目名称</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入项目名称" name="project_name"
                               value="{{$project_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入项目名称，长度最大50">
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
                        <label for="right-label" class="text-right">所属集团</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入所属集团" name="developer_group_name"
                               value="{{$developer_group_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入所属集团">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">精装总户数（体量）</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入精装总户数（体量）" name="project_volume"
                               value="{{$project_volume or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入精装总户数（体量）">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目所处阶段</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="project_step_id" id="ascription_id"
                                data-validation="required"
                                data-validation-error-msg="请选择项目所处阶段">
                            <option value="">--请选择--</option>
                            @foreach($project_step_types as $key => $name)
                                <option value="{{$key}}"
                                        @if(($project_step_id ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">联系人</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入联系人" name="contact_name"
                               value="{{$contact_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入联系人">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">岗位</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入岗位" name="position_name"
                               value="{{$position_name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入岗位">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">电话</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入电话" name="contact_phone"
                               value="{{$contact_phone or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入电话">
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