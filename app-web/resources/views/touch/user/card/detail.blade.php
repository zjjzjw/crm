<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/card/detail')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/card/detail')); ?>

<?php
Huifang\Web\Http\Controllers\Resource::addParam(

        ['id' => $id ?? 0]
);
?>

@extends('layouts.touch')
@section('content')
    <!-- 编辑-->
    <div class="detail-content">
        <!--改 type:2 编辑删除-->
        @include('partials.detail-header',
        [
        'title' => "名片详情",
        'type' => 1,
        'url'  => route('user.card.edit', ['id' => $id]), //编辑页面
        'edit_permission' => 'user.card.view.edit'
        ])
        <div class="detail-box">
            <dl>
                <dt>姓名</dt>
                <dd>{{$name or ''}}</dd>
                @if(!empty($phone))
                <dt>手机</dt>
                <dd><a href="tel:{{$phone}}">{{$phone or ''}}</a></dd>
                @endif
                @if(!empty($tel))
                <dt>电话</dt>
                <dd><a href="tel:{{$tel}}">{{empty($tel) ? '暂无' : $tel}}</a></dd>
                @endif
                <dt>邮件</dt>
                <dd>{{empty($email) ? '暂无' : $email}}</dd>
                <dt>职位</dt>
                <dd>{{$position_name or ''}}</dd>
                <dt>公司</dt>
                <dd>{{$company_name or ''}}</dd>
                <dt>地址</dt>
                <dd>{{$address or ''}}</dd>
                <dt>邮编</dt>
                <dd>{{empty($zip_code) ? '暂无' : $zip_code}}</dd>
            </dl>
        </div>
    </div>
    {{--删除--}}
    @include('partials.delete-pop')
@endsection