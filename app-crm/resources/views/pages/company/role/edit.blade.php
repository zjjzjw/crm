<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/company/role/edit')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/role/edit']); ?>
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

        <form id="form" action="{{route('company.role.store')}}"
              method="POST">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">角色名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="必填，长度最大50">
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">角色权限：</label>
                    </div>
                    <div class="small-18 columns" style="padding-top: 20px">
                        @foreach($all_permissions as $permission)
                            <div class="permission-title">{{$permission['name'] or ''}}</div>
                            @foreach($permission['nodes'] as $node)
                                <div class="permission">
                                    <input name="permissions[]" id="checkbox{{$node['id']}}" type="checkbox"
                                           @if(in_array($node['id'], $permissions))
                                           checked
                                           @endif
                                           value="{{$node['id']}}">
                                    <label for="checkbox{{$node['id']}}">{{$node['name'] or ''}}</label>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="hidden" name="company_id" value="{{$company_id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
@endsection