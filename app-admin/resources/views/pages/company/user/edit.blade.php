<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/user/edit')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/user/edit']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="wrap-content">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <form id="form" action="{{route('company.user.store')}}" method="post">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">帐号名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="name" maxlength="50"
                               value="{{$user_info['name'] or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入帐号名称！">
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">邮箱：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="email" maxlength="30"
                               value="{{$user_info['email'] or ''}}"
                               data-validation="required length email"
                               data-validation-length="max30"
                               data-validation-error-msg="请输入正确格式的邮箱！">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">手机号：</label>
                    </div>
                    <div class="small-18 columns">
                        <input class="tel" type="text" placeholder="" name="phone" maxlength="11"
                               value="{{$user_info['phone'] or ''}}"
                               data-validation="required length phone"
                               data-validation-length="max11"
                               data-validation-error-msg="请输入正确手机号">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">生效时间：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="start_time" class="date"
                               value="{{$user_info['start_time'] or ''}}"
                               data-validation="date required"
                               data-validation-length="yyyy-mm-dd"
                               data-validation-error-msg="必填，格式yyyy-mm-dd">
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">失效时间：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="end_time" class="date"
                               value="{{$user_info['end_time'] or ''}}"
                               data-validation="date required"
                               data-validation-length="yyyy-mm-dd"
                               data-validation-error-msg="必填，格式yyyy-mm-dd">
                    </div>
                </div>


                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">角色权限：</label>
                    </div>
                    <div class="small-18 columns permission">
                        @foreach($roles ?? [] as $role)
                            <input name="role_ids[]" id="checkbox{{$role['id']}}" type="checkbox"
                                   @if(in_array($role['id'], $user_info['role_ids'] ?? []))
                                   checked
                                   @endif
                                   value="{{$role['id']}}"
                                   data-validation="checkbox_group" data-validation-qty="min1"
                                   data-validation-error-msg="请选择至少1个角色权限">
                            <label for="checkbox{{$role['id']}}">{{$role['name'] or ''}}</label>
                        @endforeach
                    </div>
                </div>
              <div class="row">
                  <div class="small-6 columns">
                      <label for="right-label" class="text-right">部门：</label>
                  </div>
                  <div class="small-18 columns">
                      <div class="depart"
                            >{{$user_info['depart_name'] ?? ''}}</div>
                      <input name="depart_ids[]" type="hidden"
                              data-validation="required"
                              data-validation-error-msg="请选择所在部门!"
                              value="{{$user_info['depart_ids']['0'] ?? 0}}"></input>
                  </div>
              </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">头像：</label>
                    </div>
                    <div class="small-18 columns" style="height: auto;">
                        @include('pages.common.add-picture', [
                            'single' => true,
                            'tips' => '上传头像',
                            'name' => 'user_images',
                            'images' => $user_info['user_images'] ?? [],
                        ])
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
    <script type="text/html" id="departBoxTpl">
        <div class="content">
            <p class="title">部门选择：</p>
            <div class="depart-box">
              <ul class="first-level">
              @foreach($departs ?? [] as $depart)
                <li>
                  <div>
                    <span class="left-icon to-all" data-parentid="0" data-id="{{$depart['id']}}">+</span>
                    <label for="checkbox{{$depart['id']}}">{{$depart['name'] or ''}}</label>
                    <input class="depart-choose" name="depart_ids[]" id="checkbox{{$depart['id']}}" type="checkbox"
                      @if(in_array($depart['id'], $user_info['depart_ids'] ?? []))
                       checked
                       @endif
                       value="{{$depart['id']}}">
                  </div>
                </li>
              @endforeach
              </ul>
            </div>
            <div class="bottom-center">
                <p class="choose-error" style="display: none;">请选择部门</p>
                <input type="hidden" name="departId" value="{{$user_info['depart_ids']['0'] ?? 0}}">
                <input type="hidden" name="departName" value="{{$user_info['depart_name'] ?? 0}}">
                <input type="submit" class="save button" value="确定">
                <input type="button" class="close button" value="取消">
            </div>
        </div>
    </script>
    <script type="text/html" id="node_tpl">
        <ul class="level-box">
            <% for ( var i = 0; i < result.length; i++ ) { %>
            <li>
              <div>
                  <span class="left-icon to-all" data-parentid="<%=result[i].parent_id%>" data-id="<%=result[i].id%>">+</span>
                  <label for="checkbox<%=result[i].id%>"><%=result[i].name%></label>
                  <input class="depart-choose" name="depart_ids[]" id="checkbox<%=result[i].id%>" type="checkbox"
                    <%if(result[i].select){%>
                            checked
                          <%}%>
                       value="<%=result[i].id%>">
                </div>
            </li>
            <% } %>
        </ul>
    </script>
    @include('pages.common.add-picture-item')
@endsection