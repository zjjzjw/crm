<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/product/edit']); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addJS(['app/company/product/edit']); ?>
<?php
Huifang\Admin\Http\Controllers\Resource::addParam(
        [
                'area'          => $area ?? [],
                'ascription'    => $ascription ?? 0,
                'ascription_id' => $ascription_id ?? 0,
                'company_id'    => $company_id ?? 0,
        ]
)
?>
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

        <form id="form" action="{{route('company.product.store')}}" method="POST">
            <div class="content">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">产品归属：</label>
                    </div>
                    <div class="small-9 columns">
                        <select name="ascription" id="ascription"
                                data-validation="required"
                                data-validation-error-msg="请选择产品归属！">
                            <option value="">--请选择--</option>
                        </select>
                    </div>
                    <div class="small-9 columns">
                        <select name="ascription_id" id="ascription_id"
                                data-validation="required"
                                data-validation-error-msg="请选择公司名称！">
                            <option value="">--请选择--</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">产品分类：</label>
                    </div>
                    <div class="small-18 columns">
                        <select name="category_id"
                                data-validation="required"
                                data-validation-error-msg="请选择产品分类！">
                            <option value="">--请选择--</option>
                            @foreach($categories as $category)
                                <option value="{{$category['id']}}"
                                        @if(($category_id ?? 0) == $category['id'] )
                                        selected
                                        @endif
                                >{{$category['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">产品名称：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入产品名称" name="name"
                               value="{{$name or ''}}"
                               data-validation="required length"
                               data-validation-length="max50"
                               data-validation-error-msg="请输入产品名称，长度最大50">
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">产品价格：</label>
                    </div>
                    <div class="small-18 columns">
                        <input type="text" placeholder="请输入产品价格" name="price"
                               value="{{$price or ''}}"
                               data-validation="required length"
                               data-validation-length="max10"
                               data-validation-error-msg="请输入产品价格，长度最大10">
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">产品图片：</label>
                    </div>
                    <div class="small-18 columns" style="height: auto;">
                        @include('pages.common.add-picture', [
                            'single' => false,
                            'tips' => '添加图片',
                            'name' => 'product_images',
                            'images' => $product_images ?? [],
                        ])
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label for="right-label" class="text-right">添加参数：</label>
                    </div>
                    <ul class="small-18 columns add-parameter">
                        <?php $key = 0; ?>
                        @foreach(!empty($params) ? $params : [''] as $parameter)
                            <li>
                                <div class="small-5 columns">
                                    <label for="right-label" class="text-right">参数名称：</label>
                                </div>
                                <div class="small-6 columns">
                                    <input type="text" placeholder="请输入参数名称" name="parameter[name][]"
                                           value="{{$parameter['name'] or ''}}"
                                           data-validation="required length"
                                           data-validation-length="max100"
                                           data-validation-error-msg="请输入参数名称">
                                </div>
                                <div class="small-5 columns">
                                    <label for="right-label" class="text-right">参数值：</label>
                                </div>
                                <div class="small-6 columns">
                                    <input type="text" placeholder="请输入参数数值" name="parameter[value][]"
                                           value="{{$parameter['value'] or ''}}"
                                           data-validation="required length"
                                           data-validation-length="max100"
                                           data-validation-error-msg="请输入参数数值">
                                </div>
                                @if($key  == 0 )
                                    <div class="small-2 columns add-parameter-btn">
                                        <a href="JavaScript:;">+</a>
                                    </div>
                                @else
                                    <div class="small-2 columns del-parameter-btn">
                                        <a href="JavaScript:;">x</a>
                                    </div>
                                @endif
                            </li>
                            <?php $key++  ?>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="hidden" name="company_id" value="{{$company_id ?? 0}}">
                <input type="submit" class="button small-width" value="保存">
            </div>
        </form>
    </div>


    <script type="text/html" id="parameter_tpl">
        <li>
            <div class="small-5 columns">
                <label for="right-label" class="text-right">参数名称：</label>
            </div>
            <div class="small-6 columns">
                <input type="text" placeholder="请输入参数名称" name="parameter[name][]" value=""
                       data-validation="required length"
                       data-validation-length="max100"
                       data-validation-error-msg="请输入参数名称">
            </div>
            <div class="small-5 columns">
                <label for="right-label" class="text-right">参数值：</label>
            </div>
            <div class="small-6 columns">
                <input type="text" placeholder="请输入参数数值" name="parameter[value][]"
                       value=""
                       data-validation="required length"
                       data-validation-length="max100"
                       data-validation-error-msg="请输入参数数值">
            </div>
            <div class="small-2 columns del-parameter-btn">
                <a href="JavaScript:;">x</a>
            </div>
        </li>
    </script>
    @include('pages.common.add-picture-item')
@endsection