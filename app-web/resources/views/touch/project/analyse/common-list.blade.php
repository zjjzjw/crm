<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/analyse/common-list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/analyse/common-list')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'project_id' => $project_id ?? 0
]);
$choose = [
        'title'        => $title ?? '',
        'url'          => route('project.analyse.common-edit', ['project_id' => $project_id ?? 0, 'type' => $type ?? 0, 'id' => $id ?? 0]),
        'choose_items' => []
]
?>

@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.list-header', array('choose' => $choose, 'add_permission' => 'project.analyse.add'))
        <div class="list-box">

            @if(!empty($project_analyses))
                @foreach($project_analyses as $project_analyse)
                    <a href="{{route('project.analyse.common-detail',
                ['project_id' => $project_analyse['project_id'], 'id' => $project_analyse['id']])}}">
                        {{$project_analyse['event_desc'] or ''}}<span>></span>
                    </a>
                @endforeach
            @else
                <p class="no-data">暂无事件描述，请在右上角选择添加！</p>
            @endif

        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link',['project_id' => $project_id])
@endsection