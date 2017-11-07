<?php Huifang\Site\Http\Controllers\Resource::addCSS(['css/partials/header']);
?>
<div class="header-info">
    <div class="header-top">
        <a href="{{route('home')}}">
            <img class="img-lg" src="<?php echo isset($host) ? $host : ''; ?>/image/lg.png">
        </a>
        <div class="nav-con">
            <a href="{{route('home')}}" class="@if(in_array(request()->route()->getName(),['home',''])) active @endif normal">首页</a>
            <a href="{{route('product')}}" class="@if(request()->route()->getName() == 'product') active @endif normal product-link">产品</a>
        </div>
    </div>
    <div class="header-banner">
        <div class="bg-info">
            <img class="img-text" src="<?php echo isset($host) ? $host : ''; ?>/image/banner-text.png">
            <div class="text-box">
                <p>打造房建行业数据标杆！</p>
                <p>挖掘房建领域数据最大价值！</p>
                <p>引领地产商和建材供应商信息化快速发展！</p>
            </div>
        </div>
    </div>
</div>