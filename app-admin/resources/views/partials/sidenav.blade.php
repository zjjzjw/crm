<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/partials/sidebar']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/partials/sidenav')); ?>

<?php
$current_route_name = request()->route()->getName();

$left_menu = [
        'company' => [
                'company.detail'
        ],
        'depart'  => [
                'company.depart.index',
                'company.depart.edit',
        ],
        'role'    => [
                'company.role.index',
                'company.role.edit',
                'company.role.store',
        ],
        'user'    => [
                'company.user.index',
                'company.user.edit',
                'company.user.store',
                'company.user.pwd',
                'company.user.data',
        ],
        'product' => [
                'company.product.index',
                'company.product.edit',
                'company.product.store'
        ],

        'product.category' => [
                'company.product.category.index',
                'company.product.category.edit',
                'company.product.category.store'
        ],
        'rival'            => [
                'company.rival.index',
                'company.rival.edit',
                'company.rival.store'
        ],
        'sale'             => [
                'company.sale.sale.index',
                'company.sale.sale.import',
                'company.sale.sale.edit'
        ],

        'property' => [
                'company.sale.sale-property.index',
                'company.sale.sale-property.essential',
                'company.sale.sale-property.building',
                'company.sale.sale-property.property',
                'company.sale.sale-property.sales',
                'company.sale.sale-property.follow',
                'company.sale.sale-property.other'
        ],
];
?>

<div class="div-menu">
    <div class="menu-top-blank"></div>
    <ul class="vertical menu">

        <li class="one-level">
            <a href="JavaScript:;">
                <span class="caret"></span>组织管理
            </a>
            <ul class="second-level">
                <li @if(in_array($current_route_name, $left_menu['depart']))class="menu-li"@endif>
                    <a href="{{route('company.depart.index')}}">组织架构</a>
                </li>
                <li @if(in_array($current_route_name, $left_menu['role']))class="menu-li"@endif>
                    <a href="{{route('company.role.index')}}">角色管理</a>
                </li>
                <li @if(in_array($current_route_name, $left_menu['user']))class="menu-li"@endif>
                    <a href="{{route('company.user.index')}}">账号管理</a>
                </li>
            </ul>
        </li>

        <li class="one-level">
            <a href="JavaScript:;">
                <span class="caret"></span>线索管理
            </a>
            <ul class="second-level">
                <li @if(in_array($current_route_name, $left_menu['sale']))class="menu-li"@endif>
                    <a href="{{route('company.sale.sale.index')}}">销售线索</a>
                </li>
            </ul>
        </li>

        <li class="one-level">
            <a href="JavaScript:;">
                <span class="caret"></span>产品管理
            </a>
            <ul class="second-level">
                <li @if(in_array($current_route_name, $left_menu['product']))class="menu-li"@endif>
                    <a href="{{route('company.product.index')}}">产品管理</a>
                </li>
                <li @if(in_array($current_route_name, $left_menu['product.category']))class="menu-li"@endif>
                    <a href="{{route('company.product.category.index')}}">产品分类</a>
                </li>
            </ul>
        </li>

        <li class="one-level">
            <a href="JavaScript:;">
                <span class="caret"></span>公司管理
            </a>
            <ul class="second-level">
                <li @if(in_array($current_route_name, $left_menu['company']))class="menu-li"@endif >
                    <a href="{{route('company.detail')}}">公司信息</a>
                </li>
                <li @if(in_array($current_route_name, $left_menu['rival']))class="menu-li"@endif>
                    <a href="{{route('company.rival.index')}}">竞品公司</a>
                </li>
            </ul>
        </li>

        <li class="one-level">
            <a href="JavaScript:;">
                <span class="caret"></span>楼盘管理
            </a>
            <ul class="second-level">
                <li @if(in_array($current_route_name, $left_menu['property']))class="menu-li"@endif >
                    <a href="{{route('company.sale.sale-property.index')}}">楼盘数据</a>
                </li>
                <li>
                    <a href="{{route('company.sale.developer.index')}}">分公司管理</a>
                </li>
                <li>
                    <a href="{{route('company.sale.large-area.index')}}">大区管理</a>
                </li>
                <li>
                    <a href="{{route('company.sale.brand.index')}}">品牌管理</a>
                </li>
                <li>
                    <a href="{{route('company.sale.developer-group.index')}}">所属集团管理</a>
                </li>
            </ul>
        </li>
    </ul>
</div>