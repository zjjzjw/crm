<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/partials/sidebar']); ?>
<?php
$current_route_name = request()->route()->getName();

$left_menu = [
        'company'    => [
                'company.index',
                'company.edit',
                'company.depart.index',
                'company.depart.edit',
                'company.role.index',
                'company.role.edit',
                'company.user.index',
                'company.user.edit',
                'company.user.data',
                'company.user.pwd',
        ],
        'publicity'  => [
                'publicity.index',
                'publicity.edit',
        ],
        'suggestion' => [
                'suggestion.index',
                'suggestion.edit',
        ]
];
?>
<div class="div-menu">
    <div class="menu-top-blank"></div>
    <ul class="vertical menu">
        <li @if(in_array($current_route_name, $left_menu['company']))class="menu-li"@endif>
            <a href="{{route('company.index')}}">公司管理</a>
        </li>
        <li @if(in_array($current_route_name, $left_menu['publicity']))class="menu-li"@endif >
            <a href="{{route('publicity.index')}}">系统公告</a>
        </li>
        <li @if(in_array($current_route_name, $left_menu['suggestion']))class="menu-li"@endif>
            <a href="{{route('suggestion.index')}}">意见反馈</a>
        </li>
    </ul>
</div>