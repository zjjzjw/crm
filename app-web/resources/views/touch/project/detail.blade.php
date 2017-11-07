<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'id' => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "项目详情",
            'url' => route('project.edit', ['id' => $id]),
            'type' => 1, //编辑和删除
            'id'  => $id,
            'user_id' => $user_id,
            'user'    => $user,
            'edit_permission' => 'project.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>项目名称</dt>
                <dd>{{$project_name or ''}}</dd>
                <dt>项目所在地区（省、市）</dt>
                <dd>{{$province['name'] or ''}}-{{$city['name'] or '待输入'}}</dd>
                <dt>详细地址</dt>
                <dd>{{$address or '待输入'}}</dd>
                <dt>开发商名称</dt>
                <dd>{{$developer_name or '待输入'}}</dd>
                <dt>联系人</dt>
                <dd>{{$contact_name or '待输入'}}</dd>
                <dt>体量</dt>
                <dd>{{$project_volume or '待输入'}}</dd>
                <dt>合同签订时间</dt>
                <dd>{{$signed_at or ''}}</dd>
                @if(!empty($project_user))
                    <dt>负责人</dt>
                    <dd>{{$project_user['name'] or ''}}</dd>
                @else
                    <dt>负责人</dt>
                    <dd>暂无</dd>
                @endif
                @if(!empty($project_corp_user_names))
                    <dt>相关员工</dt>
                    <dd>{{implode(',', $project_corp_user_names)}}</dd>
                @else
                    <dt>相关员工</dt>
                    <dd>暂无</dd>
                @endif
            </dl>
            @if(!empty($project_file))
                <a href="{{route('project.file.detail', ['project_id' => $id ,'id' => $project_file['id']])}}">项目档案<span>></span></a>
            @else
                <a href="{{route('project.file.edit', ['project_id' => $id , 'id' => 0])}}">项目档案<span>></span></a>
            @endif
            <a href="{{route('project.structure.flow', ['project_id' => $id])}}">组织架构图<span>></span></a>
            <a href="{{route('project.purchase.list', ['project_id' => $id])}}">采购流程<span>></span></a>
            <a href="{{route('project.analyse.detail', ['project_id' => $id])}}">优劣势分析<span>></span></a>
            <a href="{{route('project.aim.main', ['project_id' => $id])}}">目标设置<span>></span></a>
        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link',['project_id' => $id])
    {{-- 删除--}}
    @include('partials.delete-pop')
    {{--权限提示--}}
    @include('partials.limit-pop')
@endsection