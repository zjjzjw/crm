<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/edit')); ?>
<?php huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/ui.search'));?>
<?php Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'id'          => $id ?? 0,
                'areas'       => $areas ?? [],
                'province_id' => $province_id ?? 0,
                'city_id'     => $city_id ?? 0,

        ]
); ?>

@extends('layouts.touch')

@section('content')
    <div class="edit-content">
        <!-- 创建-->
        @include('partials.detail-header', array('title' => $title ,'type' => 0))
        <form id="form_creat" action="" class="creat-box" method="POST">
            <p class="first-top"><span>项目名称</span>
                <input class="auto-ipt" @if(empty($id))id="auto_ipt"@endif name="project_name" placeholder="点击输入"
                       value="{{$project_name or ''}}" maxlength="20"
                       data-required="true"
                       data-descriptions="projectname"
                       data-describedby="projectname-description">
            </p>
            <div id="projectname-description" class="error-tip"></div>
            @if(empty($id))
                <div class="auto-content" id="auto_content">
                </div>
            @endif

            <p class="area">
                <span>项目所在地</span>
                <select class="province" name="province_id" id="province_id"
                        data-required="true"
                        data-descriptions="province"
                        data-describedby="province-description">
                </select>
                <select class="city-items" name="city_id" id="city_id"
                        data-required="true"
                        data-descriptions="city"
                        data-describedby="city-description">

                </select>
            </p>
            <div id="province-description" class="error-tip"></div>
            <div id="city-description" class="error-tip"></div>

            <p>
                <span>详细地址</span>
                <input class="address" name="address" placeholder="点击输入" value="{{$address or ''}}" maxlength="30"
                       data-required="true"
                       data-descriptions="detailaddress"
                       data-describedby="detailaddress-description">
            </p>
            <div id="detailaddress-description" class="error-tip"></div>

            <p>
                <span>开发商名称</span>
                <input class="developer" name="developer_name" placeholder="点击输入" value="{{$developer_name or ''}}" maxlength="20"
                       data-required="true"
                       data-descriptions="productor"
                       data-describedby="productor-description">
            </p>
            <div id="productor-description" class="error-tip"></div>

            <p><span>联系人</span>
                <input class="contact" name="contact_name" placeholder="点击输入" value="{{$contact_name or ''}}" maxlength="10"
                       data-required="true"
                       data-descriptions="person"
                       data-describedby="person-description"></p>
            <div id="person-description" class="error-tip"></div>

            <p><span>体量</span>

                <input class="volume" name="project_volume" placeholder="点击输入" value="{{$project_volume or ''}}" maxlength="10"
                       data-required="true"
                       data-pattern="^[0-9]*[1-9][0-9]*$"
                       data-descriptions="mass"
                       data-describedby="mass-description">
            </p>
            <div id="mass-description" class="error-tip"></div>

            <p><span>合同签订时间</span>
                <input name="signed_at" placeholder="点击输入"
                       value="{{$signed_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="time"
                       data-describedby="time-description">
            </p>
            <div id="time-description" class="error-tip"></div>

            {{--只有在编辑的时候才可以选择负责人--}}
            @if(!empty($id))
                <p>
                    <span>负责人</span>
                    <select name="user_id"
                            data-required="true"
                            data-descriptions="principal"
                            data-describedby="principal-description">
                        <option value="">-请选择-</option>
                        @foreach($owner_users as $owner_user)
                            <option value="{{$owner_user['id']}}"
                                    @if($user_id == $owner_user['id'])  selected @endif>
                                {{$owner_user['name']}}
                            </option>
                        @endforeach
                    </select>
                </p>
                <div id="principal-description" class="error-tip"></div>
            @endif

            <p><span>合作人员</span>
                <input class="add-partner" name="partner" placeholder="点击选择"
                       value="{{implode(',', $project_corp_user_names ?? [])}}"
                       data-descriptions="partner"
                       data-describedby="partner-description">
            </p>

            <div id="partner-description" class="error-tip"></div>

            <div class="save-box">
                <input type="hidden" name="project_corp_user_ids" id="cooperation_user_ids"
                       value="{{implode(',', $project_corp_user_ids ?? [])}}"/>
                <input name="id" type="hidden" value="{{$id or 0}}">
                @if(!empty($id))
                    <input class="save-btn" type="submit" value="保存">
                @else
                    <input class="save-btn" type="submit" value="创建">
                @endif
            </div>
        </form>
    </div>



    <!--负责人分配-->
    <div class="principal-content" style="display: none;">
        <div class="detail-header">
            <div class="header-box">
                <a id="com_back" class="com-back assign-back" href="javascript:;">
                    <i class="iconfont">&#xe624;</i>
                </a>
                <span class="title">合作负责人</span>
            </div>
        </div>
        @foreach($cooperation_departs as $cooperation_depart)
            @if(!empty($cooperation_depart['users']))
                <div class="department">
                    <p class="name">{{$cooperation_depart['name'] or ''}}（{{count($cooperation_depart['users'])}}）<i
                                class="iconfont">&#xe624;</i></p>
                    <ul style="display: none;">
                        @foreach($cooperation_depart['users'] as $cooperation_user)
                            <li>
                                <input type="checkbox" id="checkbox{{$cooperation_user['id']}}" name="cooperation_user"
                                       @if(in_array($cooperation_user['id'], $project_corp_user_ids ?? []))
                                       checked
                                       @endif
                                       data-user-name="{{$cooperation_user['name']}}"
                                       value="{{$cooperation_user['id']}}"/>
                                <label for="checkbox{{$cooperation_user['id']}}">{{$cooperation_user['name'] or ''}}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
        <div class="principal-choose">
            <input class="principal-btn" type="button" value="确定">
        </div>
    </div>
    {{--权限提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
    <script type="text/html" id="autocomplete_tpl">
        <% for ( var i = 0; i < names.length; i++ ) { %>
        <div class="item" data-id="<%=names[i].id%>" data-name="<%=names[i].name%>" data-address="<%=names[i].address%>" data-volume="<%=names[i].project_volume%>" data-province="<%=names[i].province_id%>" data-city="<%=names[i].city_id%>">
            <h3 class="h3"><%=names[i].repName%></h3>
        </div>
        <% } %>
    </script>
@endsection