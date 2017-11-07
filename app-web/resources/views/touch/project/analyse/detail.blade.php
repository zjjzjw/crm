<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/project/analyse/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/project/analyse/detail')); ?>
<?php
Huifang\Web\Http\Controllers\Resource::addParam(
        [
                'labels'      => $labels ?? [],
                'advantage'   => $advantage ?? [],
                'inferiority' => $inferiority ?? [],
                'project_id'  => $project_id ?? 0
        ]
)
?>

@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        @include('partials.detail-header',
        [
        'title' => "优劣势分析",
        'type' => 0,
        'id'  => $id ?? 0,
        'user_id' => $user_id ?? 0,
        'user'    => $user ?? []
        ])
        <div class="mesh">
            <p class="title">综合对比</p>
            <div class="analyse-radar">
                <canvas id="canvas" class="canvas-radar" height="2" width="3"></canvas>
                <div class="trend">
                    <p class="advantage">我方</p>
                    <p class="inferiority">竞品</p>
                </div>
            </div>
        </div>
        <div class="detail-box">
            <a href="{{route('project.analyse.common-list',
            ['project_id' => $project_id,
            'type' => \Huifang\Src\Project\Domain\Model\AnalyseType::TYPE_RELATION])}}">客户关系<span>></span></a>

            <a href="{{route('project.analyse.common-list',
            ['project_id' => $project_id,
            'type' => \Huifang\Src\Project\Domain\Model\AnalyseType::TYPE_PRODUCT])}}">产品<span>></span></a>


            <a href="{{route('project.analyse.common-list',
            ['project_id' => $project_id,
            'type' => \Huifang\Src\Project\Domain\Model\AnalyseType::TYPE_PRICE])}}">价格<span>></span></a>

            <a href="{{route('project.analyse.common-list',
            ['project_id' => $project_id,
            'type' => \Huifang\Src\Project\Domain\Model\AnalyseType::TYPE_COMPETE])}}">服务<span>></span></a>


            <a href="{{route('project.analyse.common-list',
            ['project_id' => $project_id, 'type' => \Huifang\Src\Project\Domain\Model\AnalyseType::TYPE_BRAND])}}">品牌<span>></span></a>

            <a href="{{route('project.analyse.common-list',
            ['project_id' => $project_id, 'type' => \Huifang\Src\Project\Domain\Model\AnalyseType::TYPE_OTHER])}}">其他<span>></span></a>
        </div>
    </div>
    {{--项目管理链接--}}
    @include('partials.more-link', ['project_id' => $project_id])
@endsection