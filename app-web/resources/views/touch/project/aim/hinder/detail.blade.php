<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/aim/hinder/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/hinder/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id ?? 0,
        'aim_id'     => $aim_id ?? 0,
        'id'         => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
        'title' => "障碍详情",
        'type' => 1,
        'id'  => $id ?? 0,
        'url' => route('project.aim.hinder.edit',['project_id' => $project_id, 'aim_id' => $aim_id, 'id' => $id]),
        'user_id' => $user_id ?? 0,
        'user'    => $user ?? [],
        'edit_permission' => 'project.aim.hinder.view.edit' //添加和删除目标障碍
        ])
        <div class="detail-box">
            <dl>
                <dt>障碍</dt>
                <dd>{{$hinder_name or ''}}</dd>
                <dt>实施计划</dt>
                <dd>{{$implementation_plan or ''}}</dd>
                <dt>执行时间</dt>
                <dd>{{$executed_at or ''}}</dd>
                <dt>关联采购流程</dt>
                <dd>{{$project_purchase['name'] or ''}}</dd>
                <dt>结果反馈</dt>
                <dd>{{$feedback or ''}}</dd>
                <dt>资源申请</dt>
                <dd>{{$resource_application or ''}}</dd>
                <dt>审核结果</dt>
                <dd>{{$status_name or ''}}</dd>
            </dl>
        </div>
    </div>
    {{--删除--}}
    @include('partials.delete-pop')
@endsection