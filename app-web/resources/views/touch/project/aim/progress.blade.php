<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/aim/progress')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/aim/progress')); ?>
@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.detail-header',
        [
        'title' => "销售进度",
        'type' => 0,
        'id'  => $id ?? 0,
        'user_id' => $user_id ?? 0,
        'user'    => $user ?? []
        ])
    <div class="progress-bar">
        <p>销售进度</p>
        <div class="bar">
            <div style="width: {{$percent or 0}}%;">
                <span>{{$percent or 0}}%</span>
            </div>
        </div>
    </div>
    <div class="flow-content">

        <p class="tips">
            <span class="first-tip"><i class="iconfont green">&#xe61b;</i>实施计划审核已通过</span>
            <span><i class="iconfont red">&#xe61c;</i>实施计划审核未通过</span>
        </p>
        <p class="title">销售流程</p>
        <ul class="time-box">
            @foreach($project_purchases as $project_purchase)
                <li class="item-time">
                    @if(!empty($project_purchase['aim_hinders'] ))
                        <ul class="event-box">
                            @foreach($project_purchase['aim_hinders'] as $hinder)
                                <li class="item-event">
                                    <p>
                                        <span>{{$hinder['implementation_plan']}}
                                        </span>
                                        @if($hinder['status'] == \Huifang\Src\Project\Domain\Model\AimHinderStatus::STATUS_PASS)
                                            <i class="iconfont green">&#xe61b;</i>
                                        @elseif($hinder['status'] == \Huifang\Src\Project\Domain\Model\AimHinderStatus::STATUS_REJECT)
                                            <i class="iconfont red">&#xe61c;</i>
                                        @endif
                                    </p>
                                    <span class="plan-time">{{$hinder['executed_at'] or ''}}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <p class="time">
                        <span class="circle"></span>
                        {{$project_purchase['name']}}<i class="iconfont show-icon show-more">&#xe624;</i>
                        <span class="purchase-time">{{$project_purchase['timed_at']}}</span>
                    </p>


                </li>
            @endforeach
        </ul>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link',['project_id' => $project_id])
@endsection