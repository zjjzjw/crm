<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/analyse/common-edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/analyse/common-edit')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'type'       => $type ?? 0,
                'id'         => $id ?? 0,
                'project_id' => $project_id ?? 0
        ]
)
?>


@extends('layouts.touch')
@section('content')
    <!-- 创建-->
    @include('partials.detail-header', array('title' => $title ?? '', 'type' => 0))
    <form id="form_creat" action="" class="creat-box" method="POST">
        <p class="first-top"><span>事件描述</span>
            <input name="event_desc" placeholder="点击输入" value="{{$event_desc or ''}}" maxlength="500"
                   data-required="true"
                   data-descriptions="describe"
                   data-describedby="describe-description">
        </p>
        <div id="describe-description" class="error-tip"></div>

        <p class="analyse-choose">
            <span>优劣势分析</span>
            <select name="swot_type"
                    data-required="true"
                    data-descriptions="analyse"
                    data-describedby="analyse-description">
                <option value="">-请选择-</option>
                @foreach($swot_types as $key => $name)
                    <option value="{{$key}}"
                            @if(($swot_type ?? 0) == $key)
                            selected
                            @endif
                    >{{$name}}</option>
                @endforeach
            </select>
        </p>
        <div id="analyse-description" class="error-tip"></div>

        <div class="save-box">
            <input name="id" type="hidden" value="{{$id or 0}}">
            <input name="analyse_type" type="hidden" value="{{$type ?? 0}}">
            <input name="project_id" type="hidden" value="{{$project_id ?? 0}}">
            @if(!empty($id))
                <input class="save-btn" type="submit" value="保存">
            @else
                <input class="save-btn" type="submit" value="创建">
            @endif
        </div>
    </form>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection