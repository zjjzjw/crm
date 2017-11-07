<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/file/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/file/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam([
    'project_id' => $project_id ?? 0,
    'id'         => $id ?? 0
]);
?>
@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
        'title' => "档案详情",
        'url' => route('project.file.edit' ,['project_id' => $project_id, 'id' => $id]),
        'type' => 1, //编辑和删除
        'id'  => $id,
        'user_id' => $user_id ?? 0,
        'user'    => $user,
        'edit_permission' => 'project.file.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <div>
                    <span>
                        <img src="{!! isset($host) ? $host : ''!!}/image/file-detail/brand.png" alt="">
                    </span>
                    <dt class="brand-img">历史合作品牌</dt>
                    <dd>{{$history_brands or ''}}</dd>
                </div>
                @foreach(($project_file_info ?? []) as $value)
                    <div>
                        <span>
                            <img src="{!! isset($host) ? $host : ''!!}/image/file-detail/model.png" alt="">
                        </span>
                        <dt class="model-img">型号</dt>
                        <dd>{{$value['file_model'] or ''}}</dd>
                    </div>
                    <div>
                        <span>
                            <img src="{!! isset($host) ? $host : ''!!}/image/file-detail/price.png" alt="">
                        </span>
                        <dt class="price-img">价格</dt>
                        <dd>{{intval($value['price'] ?? 0) ?? ''}}</dd>
                    </div>
                @endforeach
                <div>
                    <span>
                        <img src="{!! isset($host) ? $host : ''!!}/image/file-detail/brand.png" alt="">
                    </span>
                    <dt class="sale-img">本次参与品牌</dt>
                    <dd>{{$cooperation_brands or ''}}</dd>
                </div>
                <div>
                    <span>
                        <img src="{!! isset($host) ? $host : ''!!}/image/file-detail/common.png" alt="">
                    </span>
                    <dt class="common-img">评价</dt>
                    @foreach(($project_file_comment ?? []) as $value)
                        <dd>{{$value or ''}}</dd>
                    @endforeach
                </div>
                <div>
                    <span>
                        <img src="{!! isset($host) ? $host : ''!!}/image/file-detail/sale.png" alt="">
                    </span>
                    <dt class="saleagent-img">对标楼盘品牌</dt>
                    <dd>{{$bench_brands or ''}}</dd>
                </div>
            </dl>
        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
    {{--删除--}}
    @include('partials.delete-pop')
    {{--权限提示--}}
    @include('partials.limit-pop')
@endsection