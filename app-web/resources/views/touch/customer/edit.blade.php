<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/customer/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/customer/edit')); ?>

<?php Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'areas'       => $areas ?? [],
                'province_id' => $province_id ?? 0,
                'city_id'     => $city_id ?? 0,
                'id'          => $id ?? 0,
        ]
); ?>

@extends('layouts.touch')
@section('content')
    <div class="edit-content">
        {{--创建客户--}}
        @include('partials.detail-header', array('title' => $title ,'type' => 0))
        {{--表单--}}
        <form id="form_creat" class="creat-box" method="post">
            <p class="first-top">
                <span>客户名称</span>
                <input name="customer_company_name" placeholder="点击输入" value="{{$customer_company_name or ''}}"
                       maxlength="20"
                       data-required="true"
                       data-descriptions="company"
                       data-describedby="company-description">
            </p>
            <div id="company-description" class="error-tip"></div>

            <p class="area">
                <span>总部所在地</span>
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
                <span>联系人</span>
                <input name="contact_name" placeholder="点击输入" value="{{$contact_name or ''}}" maxlength="10"
                       data-required="true"
                       data-descriptions="contacts"
                       data-describedby="contacts-description">
            </p>
            <div id="contacts-description" class="error-tip"></div>

            <p>
                <span>职位</span>
                <input name="position_name" placeholder="点击输入" value="{{$position_name or ''}}" maxlength="10"
                       data-required="true"
                       data-descriptions="station"
                       data-describedby="station-description">
            </p>
            <div id="station-description" class="error-tip"></div>

            <p>
                <span>联系方式</span>
                <input name="contact_phone" placeholder="点击输入" value="{{$contact_phone or ''}}" maxlength="11"
                       data-required="true"
                       data-pattern="^1\d{10}$"
                       data-descriptions="telephone"
                       data-describedby="telephone-description">
            </p>
            <div id="telephone-description" class="error-tip"></div>

            <p>
                <span>项目数量</span>
                <input name="project_count" placeholder="点击输入" value="{{$project_count or ''}}" maxlength="5"
                       data-required="true"
                       data-pattern="^[0-9]*[1-9][0-9]*$"
                       data-descriptions="num"
                       data-describedby="num-description">
            </p>
            <div id="num-description" class="error-tip"></div>

            <p>
                <span>建设中项目数</span>
                <input name="build_project_count" placeholder="点击输入" value="{{$build_project_count or ''}}"
                       maxlength="5"
                       data-required="true"
                       data-pattern="^[0-9]*[1-9][0-9]*$"
                       data-descriptions="project_num"
                       data-describedby="project_num-description">
            </p>
            <div id="project_num-description" class="error-tip"></div>

            <p>
                <span>未来潜量</span>
                <input name="future_potential" placeholder="点击输入" value="{{$future_potential or ''}}" maxlength="10"
                       data-required="true"
                       data-pattern="^[0-9]*[1-9][0-9]*$"
                       data-descriptions="potential"
                       data-describedby="potential-description">
            </p>
            <div id="potential-description" class="error-tip"></div>


            <p>
                <span>开发记录</span>
                <input name="record" placeholder="点击输入" value="{{$record or ''}}" maxlength="40"
                       data-required="true"
                       data-descriptions="record"
                       data-describedby="record-description">
            </p>
            <div id="record-description" class="error-tip"></div>

            <p>
                <span>使用品牌</span>
                <input name="use_brand" placeholder="点击输入" value="{{$use_brand or ''}}" maxlength="40"
                       data-required="true"
                       data-descriptions="brand"
                       data-describedby="brand-description">
            </p>
            <div id="brand-description" class="error-tip"></div>


            <p>
                <span>客户等级</span>
                <select name="level" id="level"
                        data-required="true"
                        data-descriptions="level"
                        data-describedby="level-description">
                    <option value="">--请选择--</option>
                    @foreach($customer_level_types as $key => $name)
                        <option value="{{$key}}"
                                @if(($level ?? 0) == $key)
                                selected
                                @endif
                        >{{$name}}</option>
                    @endforeach
                </select>
            </p>
            <div id="level-description" class="error-tip"></div>

            <p>
                <span>预计签约时间</span>
                <input name="per_signed_at" placeholder="点击选择"
                       value="{{$per_signed_at or \Carbon\Carbon::now()->format('Y-m-d')}}"
                       type="date"
                       data-required="true"
                       data-descriptions="time"
                       data-describedby="time-description"/>
            </p>
            <div id="time-description" class="error-tip"></div>

            <div class="save-box">
                <input type="hidden" name="id" value="{{$id or 0}}">
                @if(!empty($id))
                    <input class="save-btn" type="submit" value="保存">
                @else
                    <input class="save-btn" type="submit" value="创建">
                @endif
            </div>

        </form>
    </div>
    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection