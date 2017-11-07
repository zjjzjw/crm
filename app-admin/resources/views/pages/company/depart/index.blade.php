<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/depart/index')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/depart/index']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="add-div">
        <a href="{{route('company.depart.edit', ['company_id' => $company_id, 'id' => 0])}}"
           class="button small">+创建组织</a>
    </div>

    @if (count($errors) > 0)
        <p class="error-alert">
            @foreach ($errors->all() as $key => $error)
                {{$key + 1}}、 {{ $error }}
            @endforeach
        </p>
    @endif


    @if(empty($items))
        <div class="no-info">
            <p>暂无组织</p>
            <p>点击右上角“创建组织”按钮添加</p>
        </div>
    @else
        <div class="has-info">
            <ul class="first-level-box level-box">
                @foreach($items ?? [] as $key => $item)
                <li class="first-level-item level-item" data-item="{{$item['id']}}">
                    <p><span class="left-icon to-all" data-id="{{$item['id']}}">+</span>{{$item['name']}}</p>
                    <div class="action">
                        <a class="first-edit" href="{{route('company.depart.edit',
                    [
                        'id' => $item['id']
                    ]
                    )}}">编辑</a>
                        <a class="add" href="javascript:void(0);" data-nodename="{{$item['name']}}" data-nodeid="{{$item['id']}}">添加</a>
                        <a class="first-delete" href="{{route('company.depart.delete', ['id' => $item['id']])}}">删除</a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    @endif

<script type="text/html" id="editBoxTpl">
    <div class="content">
        <input class="edit-name" type="text" placeholder="请输入修改内容" name="editname" maxlength="20">
    </div>
    <p class="node-error" style="display: none;">请输入修改内容</p>
    <div class="text-center">
        <input type="hidden" name="editid" value="">
        <input type="hidden" name="edittype" value="">
        <input type="hidden" name="parentid" value="">
        <input type="submit" class="save-edit button" value="确定">
        <input type="button" class="edit-close close" value="取消">
    </div>
</script>

<script type="text/html" id="nodeBoxTpl">
    <div class="content">
        <p class="parent-name"></p>
        <input class="add-node" type="text" placeholder="请输入添加内容" name="name" maxlength="20">
    </div>
    <p class="node-error" style="display: none;">请输入添加内容</p>
    <div class="text-center">
        <input type="hidden" name="id" value="">
        <input type="submit" class="save-add button" value="确定">
        <input type="button" class="add-close close" value="取消">
    </div>
</script>

<script type="text/html" id="node_tpl">
    <ul class="level-box">
        <i class="line"></i>
    <% for ( var i = 0; i < result.length; i++ ) { %>
        <li class="level-item" data-item="<%=result[i].id%>">
            <p><span class="left-icon to-all" data-id="<%=result[i].id%>">+</span><%=result[i].name%></p>
            <div class="action">
                <a class="edit" href="javascript:void(0);" data-nodename="<%=result[i].name%>" data-nodeid="<%=result[i].id%>" data-parentid="<%=result[i].parent_id%>">编辑</a>
                <a class="add" href="javascript:void(0);" data-nodename="<%=result[i].name%>" data-nodeid="<%=result[i].id%>">添加</a>
                <a class="delete" href="javascript:void(0);" data-nodename="<%=result[i].name%>" data-nodeid="<%=result[i].id%>">删除</a>
            </div>
        </li>
    <% } %>
    </ul>
</script>
@endsection