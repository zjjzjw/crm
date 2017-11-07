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
                <p class="detail-title">创建客户信息</p>
                <ol>
                    <li>
                        <p class="detail-info">点击客户管理右上角的 + 可创建新的客户信息</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/customer/1-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">填写完创建客户信息页面的所有字段后，点击创建按钮，即可创建出一条新的客户信息</p>
                    </li>
                    <li>
                        <p class="detail-info">普通员工只可查看自己创建的客户信息，领导可以查看自己所管辖的员工创建的客户信息</p>
                    </li>
                </ol>
            @elseif($type ==2)
                <p class="detail-title">编辑、删除客户信息</p>
                <ol>
                    <li>
                        <p class="detail-info">点击客户信息详情页右上角的编辑图标，即可编辑已创建的客户信息</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/customer/2-1.png">
                        </div>
                    </li>
                    <li>
                        <p class="detail-info">点击客户信息详情页右上角的删除图标，即可删除已创建的客户信息</p>
                        <div class="detail-img">
                            <img src="{!! isset($host) ? $host : ''!!}/image/help/customer/2-2.png">
                        </div>
                    </li>
                </ol>
            @endif
        </div>
    </div>
@endsection