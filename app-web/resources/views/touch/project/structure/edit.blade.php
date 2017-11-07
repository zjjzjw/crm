<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/structure/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/structure/edit')); ?>
<?php huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/ui.search'));?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
        'id'            => $id ?? 0,
        'parent_id'     => $parent_id ?? 0,
        'project_id'    => $project_id ?? 0,
        'contact_name'  => $contact_name ?? 0,
        'position_name' => $position_name ?? 0,
        'contact_phone' => $contact_phone ?? 0
]);
?>

@extends('layouts.touch')

@section('content')
    <div class="edit-content">
        <!-- 创建-->
        @include('partials.detail-header', array('title' => "创建组织架构",'type' => 0 ))

        <form id="form_creat" action="" class="creat-box" method="POST">
            <p class="first-top"><span>姓名</span>
                <input class="auto-ipt" @if(empty($id))id="auto_ipt" @endif name="name" placeholder="点击输入"
                       value="{{$name or ''}}" maxlength="10"
                       data-required="true"
                       data-descriptions="name"
                       data-describedby="name-description">
            </p>
            <div id="name-description" class="error-tip"></div>
            @if(empty($id))
                <div class="auto-content" id="auto_content">
                </div>
            @endif

            <p>
                <span>职位</span>
                <input class="position" name="position_name" placeholder="点击输入" value="{{$position_name or ''}}"
                       maxlength="10"
                       data-required="true"
                       data-descriptions="position"
                       data-describedby="position-description">
            </p>
            <div id="position-description" class="error-tip"></div>

            <p>
                <span>手机</span>
                <input class="contact" name="contact_phone" placeholder="点击选择" value="{{$contact_phone or ''}}"
                       maxlength="11"
                       data-required="true"
                       data-pattern="^1\d{10}$"
                       data-descriptions="contact"
                       data-describedby="contact-description">
            </p>
            <div id="contact-description" class="error-tip"></div>

            <p>
                <span>角色</span>
                <select name="structure_role_id"
                        data-required="true"
                        data-descriptions="role"
                        data-describedby="role-description">
                    <option value="">-请选择-</option>
                    @foreach($structure_role_types as $key =>  $name)
                        <option value="{{$key}}"
                                @if(($structure_role_id ?? 0) == $key )
                                selected
                                @endif
                        >{{$name}}</option>
                    @endforeach
                </select>
            </p>
            <div id="role-description" class="error-tip"></div>

            <p>
                <span>现阶段关系</span>
                <select name="current_related_id"
                        data-required="true"
                        data-descriptions="relation"
                        data-describedby="relation-description">
                    <option value="">-请选择-</option>
                    @foreach($current_related_types as $key =>  $name)
                        <option value="{{$key}}"
                                @if(($current_related_id ?? 0) == $key)
                                selected
                                @endif
                        >{{$name}}</option>
                    @endforeach
                </select>
            </p>
            <div id="relation-description" class="error-tip"></div>

            <div class="character-box">
                <span>性格</span>
                <div class="character-item">
                    @foreach($character_types as $key => $name)
                        <div class="check-item">
                            <input name="character[]" id="character{{$key}}" type="checkbox" value="{{$key}}"
                                   @if(in_array($key, $character_ids ?? [])) checked @endif
                                   data-required="true"
                                   data-descriptions="character"
                                   data-describedby="character-description" data-conditional="confirmlength">
                            <label for="character{{$key}}">{{$name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="character-description" class="error-tip"></div>
            <p>
                <span>兴趣点</span>
                <input name="interest" placeholder="点击输入" value="{{$interest or ''}}" maxlength="20"
                       data-required="true"
                       data-descriptions="hobby"
                       data-describedby="hobby-description">
            </p>
            <div id="hobby-description" class="error-tip"></div>

            <p>
                <span>突破计划</span>
                <input name="breakthrough_plan" placeholder="点击输入" value="{{$breakthrough_plan or ''}}" maxlength="30"
                       data-required="true"
                       data-descriptions="plan"
                       data-describedby="plan-description">
            </p>
            <div id="plan-description" class="error-tip"></div>

            <p class="result-choose">
                <span>结果反馈</span>
                @foreach($feedback_types as $key => $name)
                    <input name="feedback" type="radio" value="{{$key}}"
                           @if(($feedback ?? 0) == $key)
                           checked
                           @endif
                           id="feedback{{$key}}"><label for="feedback{{$key}}">{{$name}}</label>
                @endforeach
            </p>

            <p>
                <span>举证</span>
                <input name="proof" placeholder="点击输入" value="{{$proof or ''}}" maxlength="30"
                       data-required="true"
                       data-descriptions="testification"
                       data-describedby="testification-description">
            </p>
            <div id="testification-description" class="error-tip"></div>

            <p>
                <span>痛苦描述</span>
                <input name="pain_desc" placeholder="点击输入" value="{{$pain_desc or ''}}" maxlength="30"
                       data-required="true"
                       data-descriptions="pain"
                       data-describedby="pain-description">
            </p>
            <div id="pain-description" class="error-tip"></div>

            <p>
                <span>支持与反对</span>
                <select name="support_type"
                        data-required="true"
                        data-descriptions="support"
                        data-describedby="support-description">
                    <option value="">-请选择-</option>
                    @foreach($support_types as $key =>  $name)
                        <option value="{{$key}}"
                                @if(($support_type ?? 0) == $key)
                                selected
                                @endif
                        >{{$name}}</option>
                    @endforeach
                </select>
            </p>
            <div id="support-description" class="error-tip"></div>

            <div class="save-box">
                <input name="id" type="hidden" value="{{$id or 0}}">
                <input name="parent_id" type="hidden" value="{{$parent_id or 0}}">
                <input name="project_id" type="hidden" value="{{$project_id or 0}}">
                <input name="structure_type" type="hidden" value="{{$structure_type}}">
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
    <script type="text/html" id="autocomplete_tpl">
        <% for ( var i = 0; i < names.length; i++ ) { %>
        <div class="item" data-id="<%=names[i].id%>" data-name="<%=names[i].name%>"
                          data-position_name="<%=names[i].position_name%>" data-phone="<%=names[i].phone%>">
            <h3 class="h3"><%=names[i].repName%></h3>
        </div>
        <% } %>
    </script>
@endsection