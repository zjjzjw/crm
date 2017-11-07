<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/company/user/edit')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/user/edit']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/partials/topmenu']); ?>

@extends('layouts.master')

@section('master.content')
    @include('pages.company.partials.topmenu', ['company_id' => $company_id])

    <div class="wrap-content">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <form id="form" action="{{route('company.user.store')}}"
              method="POST">
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
                        <input type="text" placeholder="" name="phone" maxlength="11"
                               value="{{$user_info['phone'] or ''}}"
                               data-validation="required length"
                               data-validation-length="max11"
                               data-validation-error-msg="手机号，长度最大11">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">生效时间：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="start_time" class="date"
                               value="{{$user_info['start_time'] or ''}}"
                               data-validation="date"
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
                               data-validation="date"
                               data-validation-length="yyyy-mm-dd"
                               data-validation-error-msg="必填，格式yyyy-mm-dd">
                    </div>
                </div>


                <div class="row">
                    <div class="small-6 columns permission">
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
                        <select name="depart_ids[]"
                                data-validation="required"
                                data-validation-error-msg="请选择所在部门!">
                            <option value="">--请选择--</option>
                            @foreach($departs as $depart)
                                <option value="{{$depart['id'] ?? 0}}"
                                        @if(in_array($depart['id'], $user_info['depart_ids'] ?? []))
                                        selected="selected"
                                        @endif
                                >{{$depart['name'] ?? ''}}</option>
                            @endforeach
                        </select>
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
                <input type="hidden" name="created_user_id" value="{{$created_user_id ?? 0}}">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="hidden" name="company_id" value="{{$company_id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
    @include('pages.common.add-picture-item')
@endsection

