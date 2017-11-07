<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/aim/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/detail')); ?>
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
        'title' => "目标详情",
        'type' => 1,
        'id'  => $id ?? 0,
        'url' => route('project.aim.edit' , ['project_id' => $project_id ?? 0, 'id' => $id ?? 0]),
        'user_id' => $user_id ?? 0,
        'user'    => $user ?? [],
        'edit_permission' => 'project.aim.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>目标名称</dt>
                <dd>{{$name or ''}}</dd>
                @if(!empty($project_aim_products))
                    @foreach($project_aim_products as $project_aim_product)
                        <div>
                            <p class="describe">产品</p>
                            <p>{{$project_aim_product['name']}}</p>
                            <p class="describe">价格</p>
                            <p>{{$project_aim_product['price']}} 元</p>
                            <p class="describe">体量</p>
                            <p>{{$project_aim_product['volume']}}</p>
                        </div>
                    @endforeach
                @else
                    <dt>产品</dt>
                    <dd>无</dd>
                @endif
                <dt>痛点分析</dt>
                <dd>{{$pain_analysis or ''}}</dd>
                <dt>其他</dt>
                <dd>{{!empty($other) ? $other : '无'}}</dd>
            </dl>
        </div>
        <a class="hinder" href="{{route('project.aim.hinder.list', ['project_id' => $project_id, 'aim_id' => $id])}}">
            目标障碍输出<i class="iconfont">&#xe624;</i>
        </a>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link',['project_id' => $project_id])
    {{--删除--}}
    @include('partials.delete-pop')
    {{--权限提示--}}`
    @include('partials.limit-pop')
@endsection