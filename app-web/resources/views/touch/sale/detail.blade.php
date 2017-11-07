<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/sale/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/sale/detail')); ?>
<?php
$is_assign = 0;//0：未分配，1：已分配
?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'id' => $id ?? 0
])
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
        'title' => "销售线索详情",
        'type' => 1,
        'url' => route('sale.edit', ['id' => $id]),
        'id'  => $id,
        'user_id' => $user_id,
        'user'    => $user,
        'edit_permission' =>  ($user->id == $user_id && //必须是自己的且已分配的销售线索
                 ($status ?? 0) == \Huifang\Src\Sale\Domain\Model\SaleStatus::ASSIGNED) ?  'sale.view.edit' : '',
        'delete_permission' =>($user->id == $user_id && //必须是自己的且已分配的销售线索
                 ($status ?? 0) == \Huifang\Src\Sale\Domain\Model\SaleStatus::ASSIGNED) ?  'sale.delete':''
        ])
        <div class="detail-box">
            <dl>
                <dt>项目名称</dt>
                <dd>{{$project_name or ''}}</dd>
                <dt>项目所在地区（省、市）</dt>
                <dd>{{$province['name'] or ''}}-{{$city['name'] or ''}}</dd>
                <dt>详细地址</dt>
                <dd>{{$address or ''}}</dd>
                <dt>所属开发商</dt>
                <dd>{{$developer_name or ''}}</dd>
                <dt>开发商所属集团</dt>
                <dd>{{$developer_group_name or ''}}</dd>
                <dt>体量</dt>
                <dd>{{$project_volume or ''}}</dd>
                <dt>项目所处阶段</dt>
                <dd>{{$project_step_type_name or ''}}</dd>
                {{--如果具有分配权限就可看到,是自己的也可以看到--}}
                @if(($user->can('sale.distribution') && (empty($user_id) || in_array($user_id, $search_user_ids))) ||
                (!empty($user_id) && !empty($user->id) && $user_id ==  $user->id)
                && ($status ?? 0) == \Huifang\Src\Sale\Domain\Model\SaleStatus::ASSIGNED
                )
                    <dt>联系人</dt>
                    <dd>{{$contact_name or ''}}</dd>
                    <dt>岗位</dt>
                    <dd>{{$position_name or ''}}</dd>
                    <dt>联系方式</dt>
                    <dd>{{$contact_phone or ''}}</dd>
                @endif
                {{--分配权限才能看到负责人是谁--}}
                @if($user->can('sale.distribution') || ($user->id == $user_id &&
                 ($status ?? 0) == \Huifang\Src\Sale\Domain\Model\SaleStatus::ASSIGNED))
                    @if(!empty($sale_user))
                        <dt>负责人</dt>
                        <dd>{{$sale_user['name'] or ''}}</dd>
                    @else
                        <dt>负责人</dt>
                        <dd>暂无</dd>
                    @endif
                @endif

                @if(!empty($close_status))
                    <dt>关闭销售线索</dt>
                    <dd>{{$close_status_name or ''}}</dd>
                    @if($close_status == \Huifang\Src\Sale\Domain\Model\SaleCloseStatus::OTHER)
                        <dt>关闭销售线索原因</dt>
                        <dd>{{$close_reason or ''}}</dd>
                    @endif
                @endif

            </dl>

            @if($user->can('sale.distribution') && (empty($user_id) || in_array($user_id, $search_user_ids) ))
                <div class="assign-lines">
                    <input class="assign-btn" value="分配销售线索" type="button">
                </div>
            @elseif(empty($user_id) && $user->can('sale.claim') && ($status ?? 0) == \Huifang\Src\Sale\Domain\Model\SaleStatus::TO_ASSIGN)
                <form id="claim_form" method="POST">
                    <div class="claim-lines">
                        <input type="hidden" value="{{$id}}" name="sale_id"/>
                        <input class="claim-btn" value="认领销售线索" type="button">
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!--负责人分配-->
    <div class="principal-content" style="display: none;">

        <form id="assign_form">
            <div class="detail-header">
                <div class="header-box">
                    <a id="com_back" class="com-back assign-back" href="javascript:;">
                        <i class="iconfont">&#xe624;</i>
                    </a>
                    <span class="title">分配销售线索</span>
                </div>
            </div>

            @foreach($assign_departs as $assign_depart)
                @if(count($assign_depart['users'] ?? []) > 0)
                    <div class="department">
                        <p class="name">{{$assign_depart['name'] ?? ''}}（{{count($assign_depart['users'] ?? [])}}）
                            <i class="iconfont">&#xe624;</i></p>
                        <ul style="display: none;">
                            @foreach($assign_depart['users'] ?? [] as $user)
                                <li><input id="male{{$user['id'] ?? 0}}" type="radio" name="user_id"
                                           @if($user['id'] == $user_id)
                                           checked
                                           @endif
                                           value="{{$user['id'] ?? ''}}"/>
                                    <label for="male{{$user['id'] ?? 0}}">{{$user['name'] ?? ''}}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach

            <div class="principal-choose">
                <input type="hidden" value="{{$id}}" name="sale_id"/>
                <input class="principal-btn" type="button" value="确定">
            </div>
        </form>
    </div>
    {{--删除--}}
    @include('partials.delete-pop')
    {{--错误提示--}}
    @include('partials.limit-pop')
@endsection