<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/structure/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/structure/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id ?? 0,
        'id'         => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
        'title' => "组织架构详情",
        'url' => route('project.structure.edit', ['project_id' => $project_id,'parent_id' => $parent_id, 'id'=> $id]),
        'type' => 1,//删除和编辑
        'id'  => $id  ?? 0,
        'user_id' => $user_id ?? 0,
        'user'    => $user ?? [],
        'edit_permission' => 'project.structure.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>姓名</dt>
                <dd>{{$name or ''}}</dd>
                <dt>职位</dt>
                <dd>{{$position_name or ''}}</dd>
                <dt>联系方式</dt>
                <dd>{{$contact_phone or ''}}</dd>
                <dt>角色</dt>
                <dd>{{$structure_role_type_name or ''}}</dd>
                <dt>现阶段关系</dt>
                <dd>{{$current_related_type_name or ''}}</dd>
                <dt>性格</dt>
                <dd>{{implode(',', $character_names ?? []) }}</dd>
                <dt>兴趣点</dt>
                <dd>{{$interest or ''}}</dd>
                <dt>突破计划</dt>
                <dd>{{$breakthrough_plan or ''}}</dd>
                <dt>结果反馈</dt>
                <dd>{{$feedback_name or ''}}</dd>
                <dt>举证</dt>
                <dd>{{$proof or ''}}</dd>
                <dt>痛苦描述</dt>
                <dd>{{$pain_desc or ''}}</dd>
                <dt>支持与反对</dt>
                <dd>{{$support_type_name or ''}}</dd>
            </dl>
        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
    {{--删除--}}
    @include('partials.delete-pop')
    {{--权限提示--}}
    @include('partials.limit-pop')
@endsection