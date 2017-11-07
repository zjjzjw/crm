<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/publicity/index')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/publicity/index']); ?>

@extends('layouts.master')

@section('master.content')
    <div class="add-div">
        <a href="{{route('publicity.edit', ['id' => 0])}}"
           class="button small">+公告</a>
    </div>

    <table class="unstriped" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="400">标题</th>
            <th width="400">发布时间</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{$item['title'] or ''}}</td>
                <td>{{$item['created_at'] or ''}}</td>
                <td>
                    <a href="{{route('publicity.edit', ['id' => $item['id']])}}">详情</a>
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

@endsection