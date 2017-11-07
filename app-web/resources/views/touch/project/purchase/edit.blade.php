<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/purchase/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/purchase/edit')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'project_id' => $project_id  ?? 0
        ]
);
?>

@extends('layouts.touch')
@section('content')
    <!-- 创建-->
    @include('partials.detail-header',array('title' => "创建采购线索",'type' => 0))

    <form id="form_creat" action="" class="creat-box" method="POST">
        <p class="first-top"><span>名称</span>
            <input name="name" placeholder="点击输入" value="{{$name or ''}}" maxlength="10"
                   data-required="true"
                   data-descriptions="name"
                   data-describedby="name-description">
        </p>
        <div id="name-description" class="error-tip"></div>

        <p>
            <span>人员</span>
            <input name="personnel" placeholder="点击输入" value="{{$personnel or ''}}" maxlength="500"
                   data-required="true"
                   data-descriptions="member"
                   data-describedby="member-description">
        </p>
        <div id="member-description" class="error-tip"></div>

        <p>
            <span>时间</span>
            <input name="timed_at" type="date" placeholder="点击输入"
                   value="{{$timed_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                   data-required="true"
                   data-descriptions="time"
                   data-describedby="time-description">
        </p>
        <div id="time-description" class="error-tip"></div>

        <p>
            <span>事件</span>
            <input name="event_desc" placeholder="点击输入" value="{{$event_desc or ''}}" maxlength="500"
                   data-required="true"
                   data-descriptions="event"
                   data-describedby="event-description">
        </p>
        <div id="event-description" class="error-tip"></div>


        <div class="save-box">
            <input name="project_id" type="hidden" value="{{$project_id or '0'}}">
            <input name="id" type="hidden" value="{{$id or 0}}">
            @if(!empty($id))
                <input class="save-btn" type="submit" value="保存">
            @else
                <input class="save-btn" type="submit" value="创建">
            @endif
        </div>
    </form>
    {{--权限提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection