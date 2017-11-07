<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/company/user/data')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/user/data']); ?>
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

        <form id="form" action="{{route('company.user.data.store')}}"
              method="POST">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">角色权限：</label>
                    </div>
                    <div class="small-18 columns">
                        @foreach($departs ?? [] as $depart)
                            <div class="permission">
                                <input name="depart_ids[]" id="checkbox{{$depart['id']}}" type="checkbox"
                                       @if(in_array($depart['id'], $user_data_ids ?? []))
                                       checked
                                       @endif
                                       value="{{$depart['id']}}">
                                <label for="checkbox{{$depart['id']}}">{{$depart['name'] or ''}}</label>
                            </div>
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