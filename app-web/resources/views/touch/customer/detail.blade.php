<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/customer/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/customer/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'id' => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    {{--编辑--}}
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "客户详情",
            'url' => route('customer.edit', ['id' => $id ?? 0]),
            'type' => 1, //编辑和删除
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => 'customer.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>客户名称</dt>
                <dd>{{$customer_company_name or ''}}</dd>
                <dt>总部所在地</dt>
                <dd>{{$province['name'] or ''}} {{$city['name'] or ''}}</dd>
                <dt>联系人</dt>
                <dd>{{$contact_name or ''}}</dd>
                <dt>岗位</dt>
                <dd>{{$position_name or ''}}</dd>
                <dt>联系方式</dt>
                <dd>{{$contact_phone or ''}}</dd>
                <dt>项目数量</dt>
                <dd>{{$project_count or ''}}</dd>
                <dt>建设项目数量</dt>
                <dd>{{$build_project_count or ''}}</dd>
                <dt>未来浅量</dt>
                <dd>{{$future_potential or ''}}</dd>
                <dt>开发记录</dt>
                <dd>{{$record or ''}}</dd>
                <dt>使用品牌</dt>
                <dd>{{$use_brand or ''}}</dd>
                <dt>客户等级</dt>
                <dd>{{$level_name or ''}}</dd>
                <dt>预计签约时间</dt>
                <dd>{{$per_signed_at or ''}}</dd>
            </dl>
            <a href="{{route('customer.structure.flow', ['project_id' => $id])}}">组织架构图<span>></span></a>
        </div>
    </div>
    {{-- 删除--}}
    @include('../../partials.delete-pop')
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection