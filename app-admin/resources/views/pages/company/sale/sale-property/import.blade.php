<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/import']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/sale-property/import']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="wrap-content">

        <form id="form">
            <div class="content">

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">楼盘数据：</label>
                    </div>
                    <div class="small-18 columns" style="height: auto;">
                        @include('pages.common.add-picture', [
                            'single' => true,
                            'tips' => '选择数据',
                            'name' => '',
                            'images' => [],
                        ])
                    </div>
                    <p class="error-tip-picture error-tip" style="display: none;">请上传产品图片</p>
                </div>

            </div>
            <div class="text-center">
                <input type="hidden" name="company_id" value="{{$id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>

    @include('pages.common.add-picture-item')
@endsection