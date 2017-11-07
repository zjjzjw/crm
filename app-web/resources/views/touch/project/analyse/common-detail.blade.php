<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/analyse/common-detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/analyse/common-detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id ?? 0,
        'type'       => $analyse_type ?? 0,
        'id'         => $id ?? 0
]);
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
        'title' => $title ?? '',
        'type' => 1,
        'url' => route('project.analyse.common-edit', [
                                                       'project_id' => $project_id ?? 0,
                                                       'type' => $analyse_type ?? 0,
                                                       'id' => $id ?? 0
                                                       ]),
        'id'  => $id ?? 0,
        'user_id' => $user_id ?? 0 ,
        'user'    => $user ?? [],
        'edit_permission' => 'project.analyse.view.edit',
        ])
        <div class="detail-box">
            <dl>
                <dt>事件描述</dt>
                <dd>{{$event_desc or ''}}</dd>
                <dt>优劣势分析</dt>
                <dd>{{$swot_type_name or '' }}</dd>
            </dl>
        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link',['project_id' => $project_id])
    {{-- 删除--}}
    @include('partials.delete-pop')
    {{-- 权限限制--}}
    @include('partials.limit-pop')
@endsection