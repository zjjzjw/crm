<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/user/index')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/user/index']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="add-div">
        <a href="{{route('company.user.edit', ['id' => 0])}}"
           class="button small">+帐号</a>
    </div>

    @if (count($errors) > 0)
        <p class="error-alert">
            @foreach ($errors->all() as $key => $error)
                {{$key + 1}}、 {{ $error }}
            @endforeach
        </p>
    @endif

    <div class="filter-box box">
        <form action="" method="GET" id="search_form">
            <div class="row">
                <div class="small-24 columns">
                    <div class="small-4 columns  form-group">
                        <label class="text-right middle">关键字：</label>
                    </div>
                    <div class="small-16 columns form-group">
                        <div class="input-group">
                            <input type="text"
                                   name="keyword"
                                   value="{{$appends['keyword'] or ''}}"
                            />
                        </div>
                    </div>
                    <div class="small-4 columns form-group">
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="submit" class="button small-width" value="搜索">
            </div>
        </form>
    </div>


    <table class="unstriped" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="200">帐号名称</th>
            <th width="200">邮箱</th>
            <th width="200">手机号</th>
            <th width="160">操作</th>
        </tr>

        </thead>
        <tbody>
        @foreach($items ?? [] as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>{{$item['email'] ?? ''}}</td>
                <td>{{$item['phone'] ?? ''}}</td>
                <td>
                    <a href="{{route('company.user.edit',
                    [
                        'id' => $item['id']
                    ]
                    )}}">
                        编辑
                    </a>
                    <a href="{{route('company.user.pwd',
                    [
                        'id' => $item['id']
                    ]
                    )}}">
                        密码
                    </a>
                    <a href="{{route('company.user.data',
                    [
                        'id' => $item['id']
                    ]
                    )}}">
                        数据
                    </a>
                    <a href="{{route('company.user.delete',
                    [
                        'id' => $item['id']
                    ]
                    )}}">
                        删除
                    </a>
                </td>
            </tr>
        @endforeach
        <tr>
        </tbody>
    </table>

    @if(!$paginate->isEmpty())
        <div class="patials-paging">
            {!! $paginate->render() !!}
        </div>
    @endif

@endsection