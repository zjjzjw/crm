<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/list/list-header')); ?>
<div class="list-header">
    <div class="header-box">
        <a id="com_back" class="com-back" href="javascript:history.back()">
            <i class="iconfont">&#xe624;</i>
        </a>
        <div class="choose-title"><span class="title">{{$choose['title']}}</span>
            @if(!empty($choose['choose_items']))
                <i id="pull_down" class="pull-down"></i>
            @endif
        </div>

        {{--搜索按钮--}}
        @if(!empty($choose['choose_items']))
            <span class="search-btn"><i class="iconfont">&#xe607;</i></span>
        @endif

        {{--添加按钮--}}
        {{--权限判断--}}
        @can($add_permission ?? '')
            <a href="{{$choose['url']  or  ''}}" class="add-btn"><i class="iconfont">&#xe637;</i></a>
        @endcan

    </div>
    {{--下拉选择--}}
    @if(!empty($choose['choose_items']))
        <div class="choose-items" style="display: none;">
            <ul>
                @foreach($choose['choose_items'] as $item)
                    <li><a href="{{$item['url']}}">{{$item['name']}}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<section id="auto_wrap" class="auto-wrap" style="display:none;">
    @include('partials.autocomplete', array('items' => $choose ?? []))
</section>

<div class="mask"></div>