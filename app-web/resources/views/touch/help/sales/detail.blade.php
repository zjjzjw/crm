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
                <p class="detail-title">创建销售线索</p>
                <ol>
                    <li>
                        <p class="detail-info">点击销售线索右上角的 + 可创建新的销售线索</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/sales/1-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">填写完创建销售线索页面的所有字段后，点击创建按钮，即可创建出一条新的销售线索</p>
                    </li>
                    <li>
                        <p class="detail-info">所有用户都可创建销售线索，新创建的销售线索会放入线索池中，供用户领取或者分配</p>
                    </li>
                </ol>
            @elseif($type ==2)
                <p class="detail-title">编辑、删除销售线索</p>
                <ol>
                    <li>
                        <p class="detail-info">点击销售线索详情页右上角的编辑图标，即可编辑已创建的销售线索</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/sales/2-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">点击销售线索详情页右上角的删除图标，即可删除已创建的销售线索</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/sales/2-2.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">只有创建销售线索的用户才有权限删除已有的销售线索</p>
                    </li>
                </ol>
            @elseif($type ==3)
                <p class="detail-title">分配销售线索</p>
                <ol>
                    <li>
                        <p class="detail-info">当用户拥有分配销售线索的权限时，在详情页底部会有分配线索的按钮</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/sales/3-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">点击后选择相应的负责人，即可把此条销售线索分配给相应的用户</p>
                    </li>
                </ol>
            @elseif($type ==4)
                <p class="detail-title">认领销售线索</p>
                <ol>
                    <li>
                        <p class="detail-info">当用户拥有分配销售线索的权限时，在详情页底部会有认领线索的按钮</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/sales/4-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">点击后即可成为此线索的负责人</p>
                    </li>
                </ol>
            @endif
        </div>
    </div>
@endsection