<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/sale/sale/detail')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale/detail']); ?>

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

        <div class="content">
            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">项目名称：</label>
                </div>
                <div class="small-18 columns">
                    {{$project_name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">项目所在地区：</label>
                </div>
                <div class="small-18 columns">
                    {{$province['name'] or ''}}-{{$city['name']}}
                </div>
            </div>
            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">详细地址：</label>
                </div>
                <div class="small-18 columns">
                    {{$address or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">所属开发商：</label>
                </div>
                <div class="small-18 columns">
                    {{$developer_name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">开发商所属集团：</label>
                </div>
                <div class="small-18 columns">
                    {{$developer_group_name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">体量：</label>
                </div>
                <div class="small-18 columns">
                    {{$project_volume or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">项目所处阶段：</label>
                </div>
                <div class="small-18 columns">
                    {{$project_step_type_name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">联系人：</label>
                </div>
                <div class="small-18 columns">
                    {{$contact_name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">岗位：</label>
                </div>
                <div class="small-18 columns">
                    {{$position_name or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">联系方式：</label>
                </div>
                <div class="small-18 columns">
                    {{$contact_phone or ''}}
                </div>
            </div>

            <div class="row">
                <div class="small-6 columns">
                    <label for="right-label" class="text-right">负责人：</label>
                </div>
                <div class="small-18 columns">
                    {{$sale_user['name'] or ''}}
                </div>
            </div>

            @if(!empty($close_status))
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">关闭销售线索：</label>
                    </div>
                    <div class="small-18 columns">
                        {{$close_status_name or ''}}
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection