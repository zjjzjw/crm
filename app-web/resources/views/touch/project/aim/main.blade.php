<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/main')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/aim/main')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id
]);
$choose = [
        'title'        => "目标设置",
        'url'          => "",
        'choose_items' => []
]
?>
@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', array('choose' => $choose))
    <div class="main-content">
        <a href="{{route('project.aim.list', ['project_id' => $project_id])}}">目标<i class="iconfont">&#xe624;</i></a>
        <a href="{{route('project.aim.progress', ['project_id' => $project_id])}}">销售进度<i class="iconfont">&#xe624;</i></a>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
@endsection