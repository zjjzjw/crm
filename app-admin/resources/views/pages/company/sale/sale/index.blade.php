<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/sale/sale/index')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale/index']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="add-div">
        <select name="" class="allocation-screening">
            <option value="">--分配筛选--</option>
            <option value="">已分配</option>
            <option value="">未分配</option>
        </select>
        <a href="" class="button allocation">自动分配
        </a>
        <a href="{{route('company.sale.sale.import')}}"
           class="button small">导入数据
        </a>
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
            <th width="400">项目名称</th>
            <th width="400">联系人</th>
            <th width="400">是否分配</th>
            <th width="160">操作</th>
        </tr>

        </thead>
        <tbody>
        @foreach($items ?? [] as $item)
            <tr>
                <td>{{$item['project_name'] or ''}}</td>
                <td>{{$item['contact_name'] or ''}}</td>
                <td>已分配</td>
                <td>
                    <a href="{{route('company.sale.sale.edit',
                    [
                        'id' => $item['id']
                    ]
                    )}}">编辑</a>
                    <a class="delete" href="{{route('company.sale.sale.delete', ['id' => $item['id']])}}">
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

    @include('pages.common.confirm-pop' ,['type' => 2])
@endsection