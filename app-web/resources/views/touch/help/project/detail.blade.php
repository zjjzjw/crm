<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/help/detail')); ?>

@extends('layouts.touch')
@section('content')
    <div class="detail-content">
        @include('partials.detail-header',
        [
            'title' => "帮助中心",
            'type' => 0
        ])
        <div class="detail-box">

            @if($type ==1)
                <p class="detail-title">创建项目</p>
                <ol>
                    <li>
                        <p class="detail-info">点击项目右上角的 + 可创建新的项目</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/1-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">创建项目时可选择合作成员，选择的合作成员也可看到项目的所有内容，但不可编辑和删除</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/1-2.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">创建的项目只有创建者、合作人员、直属领导可以看到，其他人无法查看</p>
                    </li>
                </ol>
            @elseif($type ==2)
                <p class="detail-title">编辑、删除项目</p>
                <ol>
                    <li>
                        <p class="detail-info">点击项目详情页右上角的编辑图标，即可编辑已创建的项目</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/2-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">点击项目详情页右上角的删除图标，即可删除已创建的项目</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/2-2.png">
                        </div>
                    </li>
                </ol>
            @elseif($type ==3)
                <p class="detail-title">组织架构</p>
                <dl>
                    <dt>一、添加内容</dt>
                    <dd>
                        <p class="detail-info">1.点击添加内容按钮，即可添加第一个父级内容</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/3-1.png">
                        </div>
                    </dd>
                    <dd>
                        <p class="detail-info">2.添加子节点：点击已有内容右侧的 + 图标，并且点击出现浮层中的添加按钮，可添加下一级的子节点内容</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/3-2.png">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/3-3.png">
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dt>二、编辑</dt>
                    <dd>
                        <p class="detail-info">1.点击已有内容右侧的... 图标并且点击出现浮层中的详情按钮，进入详情页。</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/3-4.png">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/3-5.png">
                        </div>
                    </dd>
                    <dd>
                        <p class="detail-info">2.进入详情页，点击详情页右上角的编辑按钮即可编辑已有的内容</p>
                    </dd>
                </dl>
                <dl>
                    <dt>三、删除</dt>
                    <dd>
                        <p class="detail-info">1.点击已有内容右侧的删除图标并且点击出现浮层中的删除按钮，即可删除已有内容</p>
                    </dd>
                    <dd>
                        <p class="detail-info">2.当删除父节点是，其下方当所有子节点也将全部删除</p>
                    </dd>
                </dl>
                <dl>
                    <dt>四、组织架构图显示说明</dt>
                    <dd>
                        <p class="detail-info">1、角色：创建时角色字段选择当内容，决定内容快当背景色，关键人（红色），干系人（蓝色），非关系人（灰色）</p>
                    </dd>
                    <dd>
                        <p class="detail-info">
                            2、现阶段关系：创建时角色字段选择的内容，决定内容块底部心的数量，无交往（0颗心），认识（1颗心），互动（2颗心），私交（3颗心），同盟（4颗心）</p>
                    </dd>
                </dl>
            @elseif($type ==4)
                <p class="detail-title">采购流程</p>
                <ol>
                    <li>
                        <p class="detail-info">点击右上角的+按钮，可添加采购流程的内容</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/4-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">采购流程最终已时间轴的形式显示，点击展开箭头后，可展开显示某一天的具体实施计划</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/project/4-2.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">点击具体流程后，可进入流程的详情页，详情页右上角点击编辑图标可编辑已有内容，点击删除图图标可删除已有内容</p>
                    </li>
                </ol>
            @elseif($type ==5)
                <p class="detail-title">采购流程</p>
                <ol>
                    <li>
                        <p class="detail-info">优劣势分析共有我与客户关系、竞品与客户关系、产品、价格、品牌、其他，6个维度</p>
                    </li>
                    <li>
                        <p class="detail-info">每一个维度都可添加相应的事件和优劣势分析</p>
                    </li>
                    <li>
                        <p class="detail-info">优劣势分析有相应的分值，优势一（10分）、优势二（20分）、优势三（30分）、劣势一（10分）、劣势二（20分）、劣势三（30）</p>
                    </li>
                    <li>
                        <p class="detail-info">每一个维度中优劣势分析的所有分值相加，在雷达图中显示</p>
                    </li>
                </ol>
            @elseif($type ==6)
                <p class="detail-title">目标设置-销售进度图</p>
                <ol>
                    <li>
                        <p class="detail-info">销售进度图，根据采购流程关联实施计划显示，每一个实施计划都有审核结果</p>
                    </li>
                    <li>
                        <p class="detail-info">销售进度，根据所有实施计划审核通过数计算</p>
                    </li>
                </ol>
            @endif
        </div>
    </div>
@endsection