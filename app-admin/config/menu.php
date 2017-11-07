<?php
return [
    // [
    //     'title'        => '首页',
    //     'menu_id'      => 1,
    //     'path'         => '/index',
    //     'prefix_route' => 'index',
    //     'sub_items'    => []
    // ],
    [
        'title'        => '客户',
        'menu_id'      => 2,
        'path'         => '/customer/mining',
        'prefix_route' => ['customer','buyer', 'index'],
        'sub_items'    => []
    ],
    [
        'title'        => '带看',
        'menu_id'      => 3,
        'path'         => '/visit',
        'prefix_route' => 'visit',
        'sub_items'    => []
    ],
    // [
    //     'title'        => '成交',
    //     'menu_id'      => 4,
    //     'path'         => '/transaction',
    //     'prefix_route' => 'transaction',
    //     'sub_items'    => []
    // ],
    [
        'title'        => '楼盘',
        'menu_id'      => 5,
        'path'         => '/loupan',
        'prefix_route' => 'loupan',
        'sub_items'    => []
    ],
    [
        'title'        => '设置',
        'menu_id'      => 6,
        'path'         => '/setting/set-phone',
        'prefix_route' => 'setting',
        'sub_items'    => [
            [
                'title'        => '外呼电话设置',
                'menu_id'      => 61,
                'path'         => '/setting/set-phone'
            ]
        ]
    ]
];
