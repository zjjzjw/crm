<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/home')); ?>
@extends('layouts.touch')
@section('content')
    <div class="top-title">
        <p class="company-name">{{$user->company->name ?? ''}}</p>
    </div>
    <div class="h-nav">
        <a href="{{route('sale.list')}}"><i class="iconfont sale-leads">&#xe662;</i>销售线索</a>
        <a href="{{route('project.list')}}"><i class="iconfont project-manage">&#xe60b;</i>项目管理</a>
        <a href="{{route('customer.list')}}"><i class="iconfont customer-manage">&#xe605;</i>客户管理</a>
        <a href="{{route('contract.list')}}"><i class="iconfont cont-manage">&#xe630;</i>合同管理</a>
        <a href="{{route('product.company.list')}}"><i class="iconfont business-card">&#xe647;</i>产品库</a>
        <a href="{{route('help.list')}}"><i class="iconfont help-center">&#xe663;</i>帮助中心</a>
    </div>
    <div class="list-content">
        <div class="progress-bar">
            <h3 class="title">本月回款进度
                <a href="{{route('contract.payment-schedule')}}">查看全部</a>
            </h3>
            <div class="bar">
                <div class="orang" style="width: {{$contract_data['percent'] or ''}}%"></div>
                <em>{{$contract_data['payment_amount'] or ''}}元(已回款)</em>
            </div>
            <p class="payment-money">{{$contract_data['total_amount'] or ''}}元</p>
        </div>


        <div class="progress-bar signed">
            <h3 class="title">本月签约进度
                <a href="{{route('contract.signed-progress')}}">查看全部</a>
            </h3>
            <div class="bar">
                <div class="green" style="width: {{$contract_sign_data['percent'] or 0}}%">
                    <em>{{$contract_sign_data['contract_amount'] or ''}}元(已签约)</em>
                </div>
            </div>
            <p class="payment-money">{{$contract_sign_data['sign_task_amount'] or ''}}元</p>
        </div>

        @if(false)
            <div class="project-count">
                <h3 class="title">项目进度统计</h3>
                <ul>
                    <li>
                        <div class="line" style="width: 50%">
                            <span>项目一</span>
                            <i>50%</i>
                            <em>项目档案</em>
                        </div>
                    </li>
                    <li>
                        <div class="line" style="width: 100%">
                            <span>项目二</span>
                            <i>100%</i>
                            <em>组织架构</em>
                        </div>
                    </li>
                    <li>
                        <div class="line" style="width: 30%">
                            <span>项目三</span>
                            <i>30%</i>
                            <em>组织架构</em>
                        </div>
                    </li>
                </ul>
            </div>
        @endif


        <div class="detailed-ist">
            <h3 class="title">当月任务清单达成情况<a href="{{route('project.task-manifest')}}">查看全部</a></h3>
            {{--
            <ul>
                <li>
                    <span class="cell">项目</span>
                    <span class="cell">事件</span>
                </li>
                @foreach($project_list as $project)
                    @if(!empty($project['hinders']))
                        <li>
                            <span class="cell">{{$project['project_name'] or  ''}}</span>

                            @foreach($project['hinders'] as $hinder)
                                <span class="row">
                                    {{$hinder['implementation_plan'] or ''}}
                                    @if($hinder['status'] == \Huifang\Src\Project\Domain\Model\AimHinderStatus::STATUS_PASS)
                                        <i class="iconfont">&#xe6ba;</i>
                                    @endif
                            </span>
                            @endforeach
                        </li>
                    @endif
                @endforeach
            </ul>
           --}}
        </div>
    </div>
@endsection