<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/sale/sale-property/index')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/index']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="add-div">
        <select name="" class="allocation-screening">
            <option value="">--编辑筛选--</option>
            <option value="">有冲突信息</option>
            <option value="">符合规则信息</option>
        </select>
        <a href="{{route('company.sale.sale-property.import')}}"
           class="button small">导入
        </a>
    </div>
    <div class="content-box">
        <table class="table" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th width="5%">编号</th>
                <th width="10%">楼盘名称</th>
                <th width="5%">省/直辖市</th>
                <th width="5%">城市</th>
                <th width="5%">区/县</th>
                <th width="10%">详细地址</th>
                <th width="5%">分公司</th>
                <th width="5%">工程大区划分</th>
                <th width="5%">项目实际跟进人</th>
                <th width="5%">当前精装户数</th>
                <th width="5%">总户数</th>
                <th width="5%">精装标准(元/m2)</th>
                <th width="5%">楼盘均价(元/m2)</th>
                <th width="5%">开盘时间</th>
                <th width="5%">交房时间</th>
                <th width="5%">更新时间</th>
                <th width="5%">操作</th>
            </tr>

            </thead>
            <tbody>
            @foreach(($items ?? []) as $item)
            <tr>
                <td>{{$item['sn'] or ''}}</td>
                <td>{{$item['loupan_name'] or ''}}</td>
                <td>{{$item['province_name'] or ''}}</td>
                <td>{{$item['city_name'] or ''}}</td>
                <td>{{$item['county_name'] or ''}}</td>
                <td>{{$item['address'] or ''}}</td>
                <td>{{$item['developer_name'] or ''}}</td>
                <td>{{$item['large_area_name'] or ''}}</td>
                <td>{{$item['user_name'] or ''}}</td>
                <td>{{$item['at_hardcover_house_total'] or ''}}</td>
                <td>{{$item['house_total'] or ''}}</td>
                <td>{{$item['hardcover_standard'] or 0}}</td>
                <td>{{$item['housing_price'] or 0}}</td>
                <td>{{$item['opening_time'] or 0}}</td>
                <td>{{$item['handing_time'] or 0}}</td>
                <td>{{$item['updated_at'] or 0}}</td>
                <td>
                    <a href="{{route('company.sale.sale-property.essential',
                    [
                        'id' => $item['id']
                    ]
                    )}}">编辑</a>
                    <a class="delete" data-id="{{$item['id']}}">
                        删除
                    </a>
                </td>
            </tr>
            @endforeach
            <tr>
            </tbody>
        </table>
    </div>
    @include('pages.common.confirm-pop' ,['type' => 2])
@endsection