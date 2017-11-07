<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/hinder/list')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam(array(
        $choose = [
                'title'        => "目标障碍输出",
                'url'          => route('project.aim.hinder.edit',
                        ['project_id' => $project_id ?? 0, 'aim_id' => $aim_id ?? 0, 'id' => 0]),
                'choose_items' => []
        ]
));
?>
@extends('layouts.touch')
@section('content')

    {{-- 头部title --}}
    @include('partials.list-header', array('choose' => $choose, 'add_permission' => 'project.aim.hinder.add'))
    <div class="list-content">
        @if(!empty($project_aim_hinders))
            <ul>
                @foreach($project_aim_hinders as $item)
                    <li>
                        <a href="{{route('project.aim.hinder.detail', ['project_id' => $item['project_id'],
                        'aim_id' => $item['aim_id'], 'id' => $item['id'] ])}}">
                            {{$item['hinder_name'] or ''}}<i class="iconfont">&#xe624;</i>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="no-data">暂无目标，请在右上角选择添加！</p>
        @endif
    </div>
@endsection