<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/partials/header']);
?>
<div class="header-info">
    <div class="header-company-info">
        {{$user->company->name or ''}}
    </div>
    <div class="header-user-info">
        您好，<span>{{$user->name or ''}}</span> | <a href="{{route('user.logout')}}">退出</a>
    </div>
</div>