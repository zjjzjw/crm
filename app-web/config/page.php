<?php

return [
    // UI pages configurations.
    //IMPORTANT: Please override in YOUR LOCAL config.
    'host'        => env('PAGE_HOST', '/www'),
    'debug'       => env('PAGE_DEBUG', true),
    'server'      => array(
        'log' => env('PAGE_LOG_SERVER_URL', 'http://s.fq960.com/uba'),
    ),
    'sandbox'     => env('PAGE_SANDBOX', null),
    'baiduhmtkey' => env('PAGE_BAIDU_HMT_KEY', '699404de6fefd77dd900c2697310a888'),
    'activity'    => [
        'items' => [

        ],
    ],
    'from_code'   => [
        'home_box'              => 'hometc-t',
        'home_ads'              => 'home-t',
        'bottom_floating_layer' => 'navi-t',
        'online_chat'           => 'list-t',
        'immediately_contact'   => 'connect1',
        'evaluation_succeed'    => 'comment1',
        'contact_owner'         => 'connect2',
        'top_floating_layer'    => 'listfc-t',
        'home_navi'             => 'home-navi',
        'connect_broker'        => 'aggw-connect1',
        'seller_house'          => 'sale-list',
        'middle_page_bottom'    => 'middle-page-bottom',
        'middle_page'           => 'middle-page',
        'bottom_fund'           => 'calculator',
        'broker_link_detail'    => 'inside-head',
        'broker_link'           => 'aggw-head',
        'broker_linklefe1'      => 'aggw-lefe1',
        'broker_linkright1'     => 'aggw-right1',
        'broker_linkright2'     => 'aggw-right2',
        'broker_linkbottom'     => 'aggw-bottom',
        'guess'                 => 'guess',
        'description'           => 'description',
        'picture'               => 'picture',
        'type'                  => 'type',
    ],
];
