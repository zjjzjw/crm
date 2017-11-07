<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/list')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam(array(
        $choose = [
                'title'        => "目标",
                'url'          => route('project.aim.edit', ['project_id' => $project_id ?? 0, 'id' => $id ?? 0]),
                'choose_items' => [],
        ]
));
?>
@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', array('choose' => $choose, 'add_permission' => 'project.aim.add'))
    <div class="list-content">
        @if(!empty($project_aims))
            <ul>
                @foreach($project_aims as $item)
                    <li>
                        <a href="{{route('project.aim.detail', ['project_id' => $item['project_id'], 'id' => $item['id']])}}">
                            {{$item['name']}}<i class="iconfont">&#xe624;</i></a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="no-data">暂无目标，请在右上角选择添加！</p>
        @endif
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
@endsection