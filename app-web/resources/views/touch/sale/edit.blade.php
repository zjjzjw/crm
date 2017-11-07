<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/sale/edit')); ?>
<?php huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/ui.search'));?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/sale/edit', 'css/ui/detail/detail-header')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'id'            => $id ?? 0,
                'areas'         => $areas ?? [],
                'province_id'   => $province_id ?? 0,
                'city_id'       => $city_id ?? 0,
                'contact_name'  => $contact_name ?? 0,
                'position_name' => $position_name ?? 0,
                'contact_phone' => $contact_phone ?? 0
        ]
); ?>

@extends('layouts.touch')
@section('content')
    <!-- 创建-->
    @include('partials.detail-header', array('title' => "创建销售线索",'type' => 0))
    <form id="form_creat" action="" class="creat-box" method="POST">
        <p class="first-top"><span>项目名称</span>
            <input name="project_name" placeholder="点击输入" value="{{$project_name or ''}}" maxlength="20"
                   data-required="true"
                   data-descriptions="projectname"
                   data-describedby="projectname-description">
        </p>
        <div id="projectname-description" class="error-tip"></div>

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
            <input name="address" placeholder="点击输入" value="{{$address or ''}}" maxlength="30"
                   data-required="true"
                   data-descriptions="detailaddress"
                   data-describedby="detailaddress-description">
        </p>
        <div id="detailaddress-description" class="error-tip"></div>

        <p>
            <span>所属开发商</span>
            <input name="developer_name" placeholder="点击输入" value="{{$developer_name or ''}}" maxlength="20"
                   data-required="true"
                   data-descriptions="productor"
                   data-describedby="productor-description">
        </p>
        <div id="productor-description" class="error-tip"></div>

        <p><span>开发商所属集团</span>
            <input name="developer_group_name" placeholder="点击输入" value="{{$developer_group_name or ''}}" maxlength="20"
                   data-required="true"
                   data-descriptions="group"
                   data-describedby="group-description">
        </p>
        <div id="group-description" class="error-tip"></div>


        <p><span>项目体量</span>
            <input name="project_volume" placeholder="点击输入" value="{{$project_volume or ''}}" maxlength="10"
                   data-pattern="^[0-9]*[1-9][0-9]*$"
                   data-required="true"
                   data-descriptions="mass"
                   data-describedby="mass-description">
        </p>
        <div id="mass-description" class="error-tip"></div>

        <p class="step">
            <span>项目所处阶段</span>
            <select name="project_step_id"
                    data-required="true"
                    data-descriptions="stage"
                    data-describedby="stage-description">
                <option value="">-请选择-</option>
                @foreach($project_step_types as $key => $name)
                    @if(!empty($key)))
                    <option value="{{$key or ''}}" @if($key == ($project_step_id ?? 0)) selected @endif >
                        {{$name or ''}}
                    </option>
                    @endif
                @endforeach
            </select>
        </p>
        <div id="stage-description" class="error-tip"></div>

        <p><span>联系人</span>
            <input class="auto-ipt" @if(empty($id))id="auto_ipt" @endif name="contact_name" placeholder="点击输入"
                   value="{{$contact_name or ''}}" maxlength="20"
                   data-required="true"
                   data-descriptions="person"
                   data-describedby="person-description">
        </p>
        <div id="person-description" class="error-tip"></div>

        <div class="auto-position">
        {{-- 这个是判断有没有联想功能 --}}
        @if(empty($id))
            <div class="auto-content" id="auto_content">
            </div>
        @endif
        </div>

        <p><span>岗位</span>
            <input class="position" name="position_name" placeholder="点击输入" value="{{$position_name or ''}}"
                   maxlength="10"
                   data-required="true"
                   data-descriptions="station"
                   data-describedby="station-description">
        </p>
        <div id="station-description" class="error-tip"></div>

        <p><span>联系方式</span>
            <input class="contact" name="contact_phone" placeholder="点击输入" value="{{$contact_phone or ''}}"
                   data-pattern="^1(3|4|5|7|8)\d{9}$"
                   data-required="true"
                   data-descriptions="contact"
                   data-describedby="contact-description">

        </p>
        <div id="contact-description" class="error-tip"></div>

        <p class="close-box">
            <span>关闭销售线索</span>
            <select class="close-sale" name="close_status"
                    data-required="true"
                    data-descriptions="close"
                    data-describedby="close-description"
                    data-conditional="confirmChoose">
                <option value="0">-请选择-</option>
                @foreach($sale_close_statuses as $key => $name)
                    <option class="choose" value="{{$key}}" @if(($close_status ?? 0) == $key) selected @endif>
                        {{$name}}
                    </option>
                @endforeach
            </select>

        </p>
        <div id="close-description" class="error-tip"></div>


        <p id='p_close_reason'
           @if(($close_status ?? 0) != \Huifang\Src\Sale\Domain\Model\SaleCloseStatus::OTHER)style="display: none;"@endif>
            <span>关闭线索原因</span>
            <input class="class-reason" placeholder="请输入关闭原因" name="close_reason" value="{{$close_reason or ''}}"
                   data-descriptions="close_reason"
                   data-describedby="close-reason-description"
                   data-conditional="confirmCloseType"
            />
        </p>
        <div id="close-reason-description" class="error-tip"></div>


        <div class="save-box">
            <input name="id" type="hidden" value="{{$id or 0}}">


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
    <script type="text/html" id="autocomplete_tpl">
        <% for ( var i = 0; i < names.length; i++ ) { %>
        <div class="item" data-id="<%=names[i].id%>" data-name="<%=names[i].name%>" data-position_name="<%=names[i].position_name%>"
                   data-phone="<%=names[i].phone%>" data->
            <h3 class="h3"><%=names[i].repName%></h3>
        </div>
        <% } %>
    </script>
@endsection