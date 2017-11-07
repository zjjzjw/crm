<?php
$current_route_name = request()->route()->getName();
$topmenu = [
        'company' => [
                'company.edit'
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
        ],
];
?>

<div class="div-company-menu">
    <ul class="menu">
        <li><a
                    @if(in_array($current_route_name, $topmenu['company']))
                    class="current"
                    @endif
                    href="{{route('company.edit', ['id' => $company_id])}}">
                公司详情
            </a>
        </li>

        <li><a
                    @if(in_array($current_route_name, $topmenu['depart']))
                    class="current"
                    @endif
                    href="{{route('company.depart.index', ['company_id' => $company_id])}}">
                部门管理
            </a>
        </li>

        <li><a
                    @if(in_array($current_route_name, $topmenu['role']))
                    class="current"
                    @endif
                    href="{{route('company.role.index', ['company_id' => $company_id])}}">
                角色管理
            </a>
        </li>

        <li><a
                    @if(in_array($current_route_name, $topmenu['user']))
                    class="current"
                    @endif
                    href="{{route('company.user.index', ['company_id' => $company_id])}}">
                账号管理
            </a>
        </li>

    </ul>
</div>
