<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/partials/header']); ?>
<div class="header-info">
    <div class="header-company-info">
        上海绘房信息技术有限公司
    </div>
    <div class="header-user-info">
        您好，<span>{{$user->name or ''}}</span> | <a href="{{route('user.logout')}}">退出</a>
    </div>
</div>