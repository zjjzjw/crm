<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/aim/hinder/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/hinder/edit')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam([
    'project_id' => $project_id ?? 0,
    'aim_id'     => $aim_id ?? 0,
    'id'         => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 创建-->
    @include('partials.detail-header', array('title' => "创建目标障碍输出",'type' => 0))
    <form id="form_creat" action="" class="creat-box" method="POST">
        <p class="first-top"><span>障碍</span>
            <input name="hinder_name" placeholder="点击输入" value="{{$hinder_name or ''}}" maxlength="500"
                   data-required="true"
                   data-descriptions="hinder"
                   data-describedby="hinder-description">
        </p>
        <div id="hinder-description" class="error-tip"></div>

        <p>
            <span>实施计划</span>
            <input name="implementation_plan" placeholder="点击输入" value="{{$implementation_plan or ''}}" maxlength="500"
                   data-required="true"
                   data-descriptions="plan"
                   data-describedby="plan-description">
        </p>
        <div id="plan-description" class="error-tip"></div>


        <p>
            <span>执行时间</span>
            <input name="executed_at" type="date" value="{{$executed_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                   data-required="true"
                   data-descriptions="executed"
                   data-describedby="executed-description">
        </p>
        <div id="executed-description" class="error-tip"></div>

        <p>
            <span>关联采购流程</span>
            <select name="project_purchase_id"
                    data-required="true"
                    data-descriptions="flow"
                    data-describedby="flow-description">
                <option value="">-请选择-</option>
                @foreach($project_purchases as $project_purchase)
                    <option value="{{$project_purchase['id']}}"
                            @if($project_purchase['id'] == ($project_purchase_id ?? 0))
                            selected
                            @endif
                    >{{$project_purchase['name']}}</option>
                @endforeach
            </select>
        </p>
        <div id="flow-description" class="error-tip"></div>

        <p>
            <span>结果反馈</span>
            <input name="feedback" placeholder="点击输入" value="{{$feedback or ''}}"
                   data-required="true"
                   data-descriptions="result"
                   data-describedby="result-description">
        </p>
        <div id="result-description" class="error-tip"></div>

        <p>
            <span>资源申请</span>
            <input name="resource_application" placeholder="点击输入" value="{{$resource_application or ''}}" maxlength="500"
                   data-required="true"
                   data-descriptions="resource"
                   data-describedby="resource-description">
        </p>
        <div id="resource-description" class="error-tip"></div>

        <div class="save-box">
            <input name="project_id" type="hidden" value="{{$project_id or 0}}">
            <input name="aim_id" type="hidden" value="{{$aim_id or 0}}">
            <input name="id" type="hidden" value="{{$id or 0}}">
            @if(!empty($id))
                <input class="save-btn" type="submit" value="保存">
            @else
                <input class="save-btn" type="submit" value="创建">
            @endif
        </div>
    </form>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection