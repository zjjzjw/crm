<?php Huifang\Mobi\Http\Controllers\Resource::addCSS(['css/product']); ?>
@extends('layouts.master')

@section('master.content')
    <div class="content-wrap">
        <div class="product-item">
            <span>楼盘数据库</span>
            <p class="detail-info">橙诺咨询楼盘数据库业务根基，是其它行业报告、销售管理工具、定制服务产品的信息源。</p>
            <img src="<?php echo isset($host) ? $host : ''; ?>/image/product/1.jpg">
            <p class="detail-title">数据库内数据全且精准：</p>
            <p>覆盖全国一线、二线、三线、重点发展城市100个；</p>
            <p>覆盖全国100强开发商；</p>
            <p>包括楼盘所有信息（字段：城市、开发商、楼盘名、拿地时间、售楼时间、开盘时间、拿地价格、销售价格、户型、面积、</p>
            <p>精装品类使用具体品牌、型号等）。</p>
        </div>
        <div class="product-item">
            <span>行业报告</span>
            <p class="detail-info">橙诺咨询提供精装修及31个精装部品行业研究报告；每季度更新一次。</p>
            <img src="<?php echo isset($host) ? $host : ''; ?>/image/product/2.jpg">
        </div>
        <div class="product-item">
            <span>销售管理工具</span>
            <p class="detail-info">橙诺咨询房建B2B销售管理工具：标准化工程项目销售流程，资源投放更精准，签单回款更准确。</p>
            <img src="<?php echo isset($host) ? $host : ''; ?>/image/product/3.jpg">
        </div>
        <div class="product-item">
            <span>定制服务</span>
            <p class="detail-info">橙诺咨询基于楼盘数据库，及深厚行业资源，可为房地产和供应商提供双向定制服务。</p>
            <img src="<?php echo isset($host) ? $host : ''; ?>/image/product/4.jpg">
        </div>
    </div>
@endsection