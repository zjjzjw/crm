<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/approval/hinder/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/approval/hinder/detail')); ?>
@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header', array('title' => "障碍输出详情",'type' => 0))
        <div class="detail-box">
            <dl>
                <dt>障碍</dt>
                <dd>{{$hinder_name or ''}}</dd>
                <dt>实施计划</dt>
                <dd>{{$implementation_plan or ''}}</dd>
                <dt>执行时间</dt>
                <dd>{{$executed_at or ''}}</dd>
                <dt>关联采购流程</dt>
                <dd>{{$project_purchase['name'] or ''}}</dd>
                <dt>结果反馈</dt>
                <dd>{{$feedback or ''}}</dd>
            </dl>
            <a class="link-aim"
               href="{{route('user.approval.hinder.detail.aim', ['aim_id' => $aim_id ])}}">目标<span>></span></a>

            <form id="form_creat" action="" class="creat-box" method="POST">
                <p>
                    <span>审核结果</span>
                    <select name="status"
                            data-required="true"
                            data-descriptions="result"
                            data-describedby="result-description">
                        <option value="">--请选择--</option>
                        @foreach($aim_hinder_statuses  as $key => $name)
                            <option value="{{$key}}"
                                    @if($status == $key)
                                    selected
                                    @endif
                            >{{$name}}</option>
                        @endforeach
                    </select>
                </p>
                <div id="result-description" class="error-tip"></div>
                <div class="save-box">
                    <input name="id" type="hidden" value="{{$id or 0}}">
                    <input class="save-btn" type="submit" value="保存">
                </div>
            </form>
        </div>
    </div>

@endsection