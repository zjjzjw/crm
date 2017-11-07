<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/follow','css/lib/autocomplete/autocomplete','css/lib/datetimepicker/jquery.datetimepicker']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/follow']); ?>

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
                        <label for="right-label" class="text-right">所属集团</label>
                    </div>
                    <div class="small-18 columns content-style">
                        <input type="text" placeholder="请输入所属集团" name=""
                               value="{{$developer_group_name or ''}}"
                               data_id="developer_group_id"
                               id="keyword"
                               data-validation="required"
                               data-validation-error-msg="请输入所属集团"/>
                        <input type="hidden" name="developer_group_id" value="{{$developer_group_id or 0}}">
                        <div class="content-wrap"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">战略归属</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="strategy_id" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请输入战略归属">
                            <option value="">--请选择--</option>
                            @foreach($strategy_ids as $key => $name)
                                <option value="{{$key}}"
                                        @if(($strategy_id ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">其它战略品牌</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入其它战略品牌" name="strategy_brand_other"
                               value="{{$strategy_brand_other or ''}}"
                               data-validation="required"
                               data-validation-error-msg="请输入其它战略品牌"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">厨电预算(元/套)</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入厨电预算(元/套)" name="kitchen_budget"
                               value="{{$kitchen_budget or 0}}"
                               data-validation="required custom"
                               data-validation-regexp=""
                               data-validation-error-msg="请输入厨电预算(元/套)"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">厨电配置(件数)</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入厨电配置(件数)" name="kitchen_configuration"
                               value="{{$kitchen_configuration or 0}}"
                               data-validation="required custom"
                               data-validation-regexp=""
                               data-validation-error-msg="请输入厨电配置(件数)"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">竞争品牌</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入竞争品牌" name="contend_brand"
                               value="{{$contend_brand or ''}}"
                               data-validation="required"
                               data-validation-error-msg="请输入竞争品牌"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目定位</label>
                    </div>
                    <div class="small-6 columns">
                        <select name="project_position" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择项目定位">
                            <option value="">--请选择--</option>
                            @foreach($project_positions as $key => $name)
                                <option value="{{$key}}"
                                        @if(($project_position ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small-4 columns">
                        <label for="right-label" class="text-right">项目状态</label>
                    </div>
                    <div class="small-8 columns">
                        <select name="project_status" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择项目状态">
                            <option value="">--请选择--</option>
                            @foreach($project_status_type as $key => $name)
                                <option value="{{$key}}"
                                        @if(($project_status ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">预估项目合同签约时间</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入预估项目合同签约时间" name="project_estimate_signed_time" maxlength="200"
                               value="{{$project_estimate_signed_time or ''}}"
                               data-validation="required"
                               data-validation-error-msg="请输入预估项目合同签约时间"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目签约金额(万元)</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入项目签约金额(万元)" name="project_estimate_price" maxlength="200"
                               value="{{$project_estimate_price or 0}}"
                               data-validation="required"
                               data-validation-error-msg="请输入项目签约金额(万元)"/>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目签约情况</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="project_estimate_status" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择项目签约情况">
                            <option value="">--请选择--</option>
                            @foreach($project_estimate_status_type as $key => $name)
                                <option value="{{$key}}"
                                        @if(($project_estimate_status ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">项目丢失情况说明(原因)</label>
                    </div>
                    <div class="small-18 columns textarea">
                        <textarea name="project_loss_reason" id=""
                                  data-validation="required length"
                                  data-validation-length="max50"
                                  data-validation-error-msg="请输入项目丢失情况说明(原因)">{{$project_loss_reason or ''}}</textarea>
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