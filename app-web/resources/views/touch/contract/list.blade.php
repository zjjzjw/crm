<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/contract/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/list', 'css/ui/list/list-items')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam(array(
        'pageInfo' => $appends ?? [],
        'listUrl'  => route($route_name ?? ''),
        'listType' => $route_name ?? ''
));
?>

@extends('layouts.touch')
@section('content')
    {{-- 头部title --}}
    @include('partials.list-header', [
               'choose' => $choose,
               'add_permission' => 'contract.add'
    ])

    <div class="all-box">
        <div class="filter">

            @if(!empty($search_users))
                <div id="menu" class="menu">
                    <div id="menuinfo">
                        <div class="menunav" id="menunav">
                            <p id="mass" class="menunav-row">
                                <span class="parentup" data-type="0">负责人</span><i class="g-touchicon-l revolve"></i>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="optionlist" id="optionlist" style="display: none;">
                    <!--负责人-->
                    <div class="mass menunav-info" id="priceinfo" style="display: none;">
                        <div class="pricelist auto-scoll">
                            <a rel="nofollow" class="@if(($appends['select_user_id'] ?? 0) == 0) active @endif"
                               href="{{route($route_name, array_merge($appends, ['select_user_id' => 0]))}}">不限</a>
                            @foreach($search_users ?? [] as $search_user)
                                <a rel="nofollow"
                                   class="@if(($appends['select_user_id'] ?? 0) == $search_user['id']) active @endif"
                                   href="{{route($route_name, array_merge($appends, ['select_user_id' => $search_user['id'] ]))}}">
                                    {{$search_user['name'] or ''}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div id="dialog" style="display: none;"></div>
        </div>
        {{-- 列表 --}}
        @include('partials.list-items',array('list_items' => $items ?? []))
    </div>

@endsection