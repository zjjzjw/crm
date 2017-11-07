<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/company/depart/index')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/depart/index']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/partials/topmenu']); ?>

@extends('layouts.master')

@section('master.content')
    @include('pages.company.partials.topmenu', ['company_id' => $company_id])

    <div class="add-div">
        <a href="{{route('company.depart.edit', ['company_id' => $company_id, 'id' => 0])}}"
           class="button small">+部门</a>
    </div>

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
            <th width="800">公司名称</th>
            <th width="160">操作</th>
        </tr>

        </thead>
        <tbody>
        @foreach($items ?? [] as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>
                    <a href="{{route('company.depart.edit',
                    [
                        'company_id' => $company_id,
                        'id' => $item['id']
                    ]
                    )}}">
                        编辑
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