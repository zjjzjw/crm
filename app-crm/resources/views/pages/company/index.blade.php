<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/company/index')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/company/index']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>

@extends('layouts.master')

@section('master.content')
    <div class="add-div">
        <a href="{{route('company.edit', ['id' => 0])}}"
           class="button small">+公司</a>
    </div>

    <div class="filter-box box">
        <form action="" method="get" id="search_form">
            <div class="row">
                <div class="small-14 columns">
                    <div class="small-4 columns form-group">
                        <label class="text-right middle">有效期：</label>
                    </div>
                    <div class="small-9 columns form-group">
                        <div class="input-group start-date">
                            <input type="text"
                                   class="date"
                                   name="start_time"
                                   value="{{$appends['start_time'] or ''}}"
                            />
                        </div>
                    </div>
                    <div class="small-1 columns form-group">
                        <div class="input-group date-line">
                            ---
                        </div>
                    </div>
                    <div class="small-9 columns form-group">
                        <div class="input-group start-date">
                            <input type="text"
                                   class="date"
                                   name="end_time"
                                   value="{{$appends['end_time'] or  ''}}"
                            />
                        </div>
                    </div>
                    <div class="small-1 columns form-group">
                        <div class="input-group">
                        </div>
                    </div>
                </div>

                <div class="small-10 columns">
                    <div class="small-4 columns  form-group">
                        <label class="text-right middle">关键字：</label>
                    </div>
                    <div class="small-20 columns form-group">
                        <div class="input-group">
                            <input type="text"
                                   name="keyword"
                                   value="{{$appends['keyword'] or ''}}"
                            />
                        </div>
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
            <th width="300">公司名称</th>
            <th width="300">有效期</th>
            <th width="200">人数</th>
            <th width="160">操作</th>
        </tr>

        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>{{$item['start_time']}}-{{$item['end_time']}}</td>
                <td>{{$item['user_number']}}</td>
                <td>
                    <a href="{{route('company.edit', ['id' => $item['id']])}}">编辑</a>
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