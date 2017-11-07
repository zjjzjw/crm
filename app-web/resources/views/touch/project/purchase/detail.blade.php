<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/purchase/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/purchase/detail')); ?>
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
        'title' => "采购详情",
        'type' => 1,
        'id'  => $id ?? 0,
        'url' => route('project.purchase.edit', ['project_id' => $project_id, 'id' => $id]),
        'user_id' => $user_id ?? 0,
        'user'    => $uer ?? [],
        'edit_permission' => 'project.purchase.view.edit'

        ])
        <div class="detail-box">
            <dl>
                <dt>名称</dt>
                <dd>{{$name or ''}}</dd>
                <dt>人员</dt>
                <dd>{{$personnel or ''}}</dd>
                <dt>时间</dt>
                <dd>{{$timed_at or ''}}</dd>
                <dt>事件</dt>
                <dd>{{$event_desc or ''}}</dd>
            </dl>
        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
    {{-- 删除--}}
    @include('partials.delete-pop')
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection