<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/file/edit')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/file/edit', 'css/ui/detail/detail-header')); ?>

<?php


Huifang\Web\Http\Controllers\Resource::addParam(
    [
        'project_id' => $project_id ?? 0,
        'id'         => $id ?? 0
    ]
);
?>

@extends('layouts.touch')
@section('content')
    {{--创建--}}
    @if(!empty($id))
        @include('partials.detail-header', array('title' => "档案详情",'type' => 0))
    @else
        @include('partials.detail-header', array('title' => "创建项目档案",'type' => 0))
    @endif
    <form id="form_creat" action="" class="creat-box" method="POST">
        <p class="first-top">
            <span>历史合作品牌</span>
            <input name="history_brands" placeholder="点击输入" value="{{$history_brands or ''}}" maxlength="10"
                   class="history-input-value"
                   data-required="true"
                   data-descriptions="historybrand"
                   data-describedby="historybrand-description">
        </p>
        <span class="historybrand-input-error" style="display: none">请输入合作品牌</span>
        <div class="product-group">
            @foreach(($project_file_info ?? []) as $value)
                <div class="product-input">
                    <p class="judge-product">
                        <span>型号</span>
                        <input name="file_model[]" placeholder="点击输入" value="{{$value['file_model'] or ''}}" maxlength="15"
                               class="model-input-value"
                               data-required="true"
                           data-descriptions="type"
                           data-describedby="type-description">
                    </p>
                    <p sclass="judge-product">
                        <span>价格</span>
                        <input name="price[]" placeholder="请输入数字"
                           value="{{intval($value['price'] ?? 0) ? intval($value['price'] ?? 0): '' }}"
                               class="price-input-value"
                               data-required="true"
                           maxlength="11"
                           data-pattern="^-?\d*\.?\d*$"
                           data-descriptions="price"
                           data-describedby="price-description">
                        </p>
                </div>
            @endforeach
        </div>
        <span class="model-input-error" style="display: none">请输入型号</span>
        <span class="price-input-error" style="display: none">请输入价格</span>
        <span class="price-error" style="display: none">价格请输入数字</span>
        <div id="product-move">
            <i>删除</i>
        </div>
        <div class="add-product">
            <i>新增产品</i>
        </div>

        <p>
            <span>本次参与品牌</span>
            <input name="cooperation_brands" placeholder="点击输入" value="{{$cooperation_brands or ''}}" maxlength="20"
                   class="cooperation-input-value"
                   data-required="true"
                   data-descriptions="brand"
                   data-describedby="brand-description">
        </p>
        <span class="cooperation-input-error" style="display: none">请输入本次参与品牌</span>

        <div class="common-group">
            @foreach(($project_file_comment ?? []) as $value)
                <div class="common-input">
                    <p class="judge-common">
                        <span>评价</span>
                        <input name="project_file_comment[]" placeholder="点击输入" value="{{$value or ''}}" maxlength="40"
                               class="common-input-value"
                               data-required="true"
                           data-descriptions="evaluation"
                           data-describedby="evaluation-description">
                    </p>
                </div>
            @endforeach
        </div>
        <span class="common-input-error" style="display: none">请输入评价</span>
        <div id="common-move">
            <i>删除</i>
        </div>
        <div class="add-common">
            <i>新增评价</i>
        </div>

        <p><span>对标楼盘品牌</span>
            <input name="bench_brands" placeholder="点击输入" value="{{$bench_brands or ''}}" maxlength="20"
                   class="bench-input-value"
                   data-required="true"
                   data-descriptions="bench"
                   data-describedby="bench-description">
        </p>
        <span class="bench-input-error" style="display: none">请输入对标楼盘品牌</span>


        <div class="save-box">
            <input name="id" type="hidden" value="{{$id or 0}}">
            <input name="project_id" type="hidden" value="{{$project_id or 0}}">
            @if(!empty($id))
                <input class="save-btn" type="button" value="保存">
            @else
                <input class="save-btn" type="button" value="创建">
            @endif
        </div>
    </form>

    <script type="text/html" id="productTpl">
        <div class="product-input">
            <p class="judge-product">
                <span>型号</span>
                <input name="file_model[]" placeholder="点击输入" value="" maxlength="15"
                       autofocus="autofocus"
                       class="model-input-value"
                       data-required="true"
                       data-descriptions="type"
                       data-describedby="type-description">
            </p>

            <p class="judge-product">
                <span>价格</span>
                <input name="price[]" placeholder="请输入数字" value=""
                       class="price-input-value"
                       data-required="true"
                       maxlength="11"
                       data-pattern="^-?\d*\.?\d*$"
                       data-descriptions="price"
                       data-describedby="price-description">
            </p>
    </script>

    <script type="text/html" id="commonTpl">
        <div class="common-input">
            <p  class="judge-common">
                <span>评价</span>
                <input name="project_file_comment[]" placeholder="点击输入" value="" maxlength="40"
                       class="common-input-value"
                       autofocus="autofocus"
                       data-required="true"
                       data-descriptions="evaluation"
                       data-describedby="evaluation-description">
            </p>
        </div>
    </script>

    {{--错误提示--}}
    @include('partials.limit-pop')
    {{--loading--}}
    @include('partials.loading')
@endsection