<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/task-manifest-detail')); ?>

@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "任务详情",
            'url' => [],
            'type' => 0,
            'id'  => $id ?? 0,
            'user_id' => $user_id ?? 0,
            'user'    => $user ?? [],
            'edit_permission' => 'salf.edit'
        ])

    </div>
    <div class="detailed-ist">
        <ul>
            <li>
                <span class="cell">项目</span>
                <span class="cell">事件</span>
            </li>
            @foreach($project_list as $project)
                @if(!empty($project['hinders']))
                    <li>
                        <span class="cell">{{$project['project_name'] or  ''}}</span>

                        @foreach($project['hinders'] as $hinder)
                            <span class="row">
                                {{$hinder['implementation_plan'] or ''}}
                                @if($hinder['status'] == \Huifang\Src\Project\Domain\Model\AimHinderStatus::STATUS_PASS)
                                    <i class="iconfont">&#xe6ba;</i>
                                @endif
                            </span>
                        @endforeach
                    </li>
                @endif
            @endforeach

        </ul>
    </div>
@endsection