<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/brand/index']); ?>
  <?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/sale/brand/index']); ?>

@extends('layouts.master')

@section('master.content')
    <div class="add-div">
        <a href="{{route('company.sale.brand.edit', ['id' => 0])}}"
           class="button small">新增</a>
    </div>

    <table class="unstriped" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="300">序号</th>
            <th width="300">品牌名称</th>
            <th width="300">公司名称</th>
            <th width="160">操作</th>
        </tr>

        </thead>
        <tbody>
        <?php $i = 1;?>
        @foreach($items ?? [] as $key=>$item)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$item['brand_name'] or ''}}</td>
            <td>{{$item['company_name'] or ''}}</td>
            <td>
                <a href="{{route('company.sale.brand.edit',
                    [
                        'id' => $item['id']
                    ]
                    )}}">
                    编辑
                </a>
                <a data-id="{{$item['id']}}" class="delete">
                    删除
                </a>
            </td>
        </tr>
        @endforeach


        </tbody>
    </table>
    @if(!$paginate->isEmpty())
    <div class="patials-paging">
    {!! $paginate->render() !!}
    </div>
    @endif
    @include('pages.common.confirm-pop' ,['type' => 2])
@endsection