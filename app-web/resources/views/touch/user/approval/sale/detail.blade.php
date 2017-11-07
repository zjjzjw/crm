<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/approval/sale/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/approval/sale/detail')); ?>
@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.detail-header', array('title' => "销售线索审核",'type' => 0))
        <div class="detail-box">
            <dl>
                <dt>项目名称</dt>
                <dd>{{$project_name or ''}}</dd>
                <dt>项目所在地区(省、市)</dt>
                <dd>{{$province['name'] or ''}}-{{$city['name'] or ''}}</dd>
                <dt>详细地址</dt>
                <dd>{{$address or ''}}</dd>
                <dt>所属开发商</dt>
                <dd>{{$developer_name or ''}}</dd>
                <dt>开发商所属集团</dt>
                <dd>{{$developer_group_name or ''}}</dd>
                <dt>项目体量</dt>
                <dd>{{$project_volume or ''}}</dd>
                <dt>项目所处阶段</dt>
                <dd>{{$project_step_type_name or ''}}</dd>
                <dt>联系人</dt>
                <dd>{{$contact_name or ''}}</dd>
                <dt>岗位</dt>
                <dd>{{$position_name or ''}}</dd>
                <dt>联系方式</dt>
                <dd>{{$contact_phone or ''}}</dd>
                <dt>负责人</dt>
                <dd>{{$sale_user['name'] or ''}}</dd>
                <dt>状态</dt>
                <dd>{{$status_name or ''}}</dd>
            </dl>
        </div>

        @if($status == \Huifang\Src\Sale\Domain\Model\SaleStatus::ASSIGNING)
            <div class="save-box">
                <input type="hidden" name="id" value="{{$id or 0}}">
                <input class="save-btn adopt" type="submit" value="通过">
                <input class="save-btn reject" type="submit" value="驳回">
            </div>
        @endif
    </div>
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection