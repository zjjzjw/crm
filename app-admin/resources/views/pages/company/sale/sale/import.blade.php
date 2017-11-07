<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale/import']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale/import']); ?>
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
        []
)
?>
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

        <form id="form" action="{{route('company.sale.sale.import.store')}}" method="POST">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">销售线索：</label>
                    </div>
                    <div class="small-18 columns" style="height: auto;">
                        @include('pages.common.add-picture', [
                            'single' => true,
                            'tips' => '选择数据',
                            'name' => 'sales',
                            'images' => [],
                        ])
                    </div>
                </div>

            </div>
            <div class="text-center">
                <input type="hidden" name="company_id" value="{{$company_id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>

    @include('pages.common.add-picture-item')
@endsection