<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/ui.navbar')); ?>
<?php $nav_route = request()->route()->getName(); ?>
<section class="nav-btm" id="panel">

    <a href="/home" class="@if($nav_route == 'home') active @endif nclick" data-origin="bottom_Bar"><i
                class="iconfont @if($nav_route == 'home') active @endif ">&#xe60c;</i>
        <div>首页</div>
    </a>
    <a href="/message/index"
       class="nclick @if(strpos($nav_route , 'message') === 0) active  @endif"
       data-origin="bottom_Bar">
        <i
                class="iconfont @if(strpos($nav_route , 'message') === 0) active  @endif">
            &#xe60d;</i>
        <div>消息</div>
    </a>
    <a href="/user/list" class="nclick @if(strpos($nav_route , 'user') === 0) active  @endif"
       data-origin="bottom_Bar"><i class="iconfont @if(strpos($nav_route , 'user') === 0) active  @endif">
            &#xe635;</i>
        <div>我</div>
    </a>
</section>