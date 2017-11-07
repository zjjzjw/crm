<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/detail/detail-header')); ?>
<div class="detail-header">
    <div class="header-box">
        <a id="com_back" class="com-back" href="javascript:history.back()">
            <i class="iconfont">&#xe624;</i>
        </a>
        <span class="title">{{$title or ''}}</span>
        {{--判断是否有编辑权限--}}
        {{--type:0：隐藏 1：编辑和删除--}}
        @if($type == 1)
            @can($edit_permission)
                <a href="{{$url}}" class="edit-btn"><i class="iconfont">&#xe675;</i></a>
                @if(!isset($delete_un_visible))
                    <a href="javascript:;" class="delete-btn"><i class="iconfont">&#xe648;</i></a>
                @endif
            @endcan
        @endif
        @if($type == 2)
            <a href="javascript:;" class="save-btn save-top">提交</a>
        @endif
    </div>
</div>