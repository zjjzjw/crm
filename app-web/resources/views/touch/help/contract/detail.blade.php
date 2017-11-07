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
                <p class="detail-title">创建合同</p>
                <ol>
                    <li>
                        <p class="detail-info">点击合同管理右上角的 + 可创建新的合同</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/contract/1-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">填写完创建合同信息页面的所有字段后，点击创建按钮，即可创建出一条新的合同信息</p>
                    </li>
                    <li>
                        <p class="detail-info">普通员工只可查看自己创建的合同信息，领导可以查看自己所管辖的员工创建的合同信息</p>
                    </li>
                </ol>
            @elseif($type ==2)
                <p class="detail-title">回款详情</p>
                <ol>
                    <li>
                        <p class="detail-info">合同详情页中，点击下方的回款，可进入该合同的回款详情页2</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/contract/2-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">回款详情页中，总额是为合同的总金额，回款数为下方所有回款记录的金额总和2</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/contract/2-2.png">
                        </div>
                    </li>
                </ol>
            @elseif($type ==3)
                <p class="detail-title">回款计划和回款记录</p>
                <ol>
                    <li>
                        <p class="detail-info">点击回款详情右上角的+，可创建回款计划和回款记录3</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/contract/3-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">
                            回款计划最多可添加10期，每一期的回款计划都可创建相应的回款记录，当某一期的回款计划金额等于当期的回款记录金额总和时，该期的回款计划状态为已完成。</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/contract/3-2.png">
                        </div>
                    </li>
                </ol>
            @endif
        </div>
    </div>
@endsection