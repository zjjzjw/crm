<?php Huifang\Crm\Http\Controllers\Resource::addJS(array('app/publicity/edit')); ?>
<?php Huifang\Crm\Http\Controllers\Resource::addCSS(['css/publicity/edit']); ?>

@extends('layouts.master')

@section('master.content')
    <div class="wrap-content">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <form id="form" action="{{route('publicity.store')}}" method="POST">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">标题</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="" name="title"
                               value="{{$title or ''}}"
                               data-validation="required length"
                               data-validation-length="max30"
                               data-validation-error-msg="必填，长度最大30">

                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">内容</label>
                    </div>
                    <div class="small-18 columns text">
                        <textarea type="text" placeholder="" name="info"
                                  data-validation="required length"
                                  data-validation-length="max300"
                                  data-validation-error-msg="必填，长度最大300">{{$info or ''}}</textarea>

                    </div>
                </div>

            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>
@endsection