<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/detail/more-link')); ?>
<?php huifang\Web\Http\Controllers\Resource::addJS(array('ui.morelink')); ?>
<div class="more-link">
    <img src="{!! isset($host) ? $host : ''!!}/image/more-link.jpg">
</div>
<div class="close-link" style="display: none;">
    <img src="{!! isset($host) ? $host : ''!!}/image/close-link.jpg">
    <div class="bg detail-link">
        <a href="{{route('project.detail',
            ['id' => $project_id])}}">项目详情</a>
    </div>
    <div class="bg file-link">
        <a href="{{route('project.file', ['project_id' => $project_id])}}">项目档案</a>
    </div>
    <div class="bg structure-link">
        <a href="{{route('project.structure.flow', ['project_id' => $project_id])}}">组织架构</a>
    </div>
    <div class="bg purchase-link">
        <a href="{{route('project.purchase.list', ['project_id' => $project_id])}}">采购流程</a>
    </div>
    <div class="bg analyse-link">
        <a href="{{route('project.analyse.detail', ['project_id' => $project_id])}}">优劣势分析</a>
    </div>
    <div class="bg aim-link">
        <a href="{{route('project.aim.main', ['project_id' => $project_id])}}">目标设置</a>
    </div>
</div>

<div class="mask"></div>