<?php Huifang\Site\Http\Controllers\Resource::addCSS(['css/home']); ?>
@extends('layouts.master')

@section('master.content')
    <div class="content-wrap">
        <div class="company-info">
            <div class="info-item">
                <img src="<?php echo isset($host) ? $host : ''; ?>/image/home/1.png">
                <div class="info-box">
                    <h4>高质楼盘数据库</h4>
                    <div class="detail-info">
                        <p>全国覆盖百强地产商</p>
                        <p>毛坯＋精装31个精装部品</p>
                    </div>
                </div>
            </div>
            <div class="info-item  right-top">
                <img src="<?php echo isset($host) ? $host : ''; ?>/image/home/2.png">
                <div class="info-box">
                    <h4>数据团队</h4>
                    <div class="detail-info">
                        <p>销售管理工具</p>
                        <p>销售线索自动导入</p>
                        <P>可视化界面</P>
                        <p>精准客户管理</p>
                        <p>便捷统计保镖</p>
                    </div>
                </div>
            </div>
            <div class="info-item bottom-line">
                <img src="<?php echo isset($host) ? $host : ''; ?>/image/home/3.png">
                <div class="info-box">
                    <h4>行业报告</h4>
                    <div class="detail-info">
                        <p>滚动更新</p>
                        <p>精装趋势</p>
                        <p>开发商痛点</p>
                        <p>各品类行业趋势</p>
                    </div>
                </div>
            </div>
            <div class="info-item bottom-line right-bottom">
                <img src="<?php echo isset($host) ? $host : ''; ?>/image/home/4.png">
                <div class="info-box">
                    <h4>定制服务</h4>
                    <div class="detail-info">
                        <p>房建双向服务</p>
                        <p>独有行业信息</p>
                        <p>企业需求解决方案</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection