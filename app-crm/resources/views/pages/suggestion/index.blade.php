<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/suggestion/index')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/suggestion/index']); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/lib/datetimepicker/jquery.datetimepicker']); ?>

@extends('layouts.master')

@section('master.content')

    @if(false)
        <div class="add-div">
            <a href="{{route('suggestion.edit', ['id' => 0])}}"
               class="button small">+意见反馈</a>
        </div>
    @endif

    <div class="filter-box box">
        <form action="" method="get" id="search_form">
            <div class="row">
                <div class="small-14 columns">
                    <div class="small-4 columns form-group">
                        <label class="text-right middle">有效期：</label>
                    </div>
                    <div class="small-9 columns form-group">
                        <div class="input-group start-date">
                            <input type="text" class="date"
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
                            <input type="text" class="date"
                                   name="end_time"
                                   value="{{$appends['end_time'] or ''}}"
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
            <th width="150">反馈时间</th>
            <th width="250">公司</th>
            <th width="100">联系方式</th>
            <th width="100">姓名</th>
            <th width="300">反馈内容</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{$item['created_at'] or ''}}</td>
                <td>{{$item['company_name'] or ''}}</td>
                <td>{{$item['contact'] or ''}}</td>
                <td>{{$item['user_name'] or ''}}</td>
                <td>{{$item['content'] or ''}}</td>
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