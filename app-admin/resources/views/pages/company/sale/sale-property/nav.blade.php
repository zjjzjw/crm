<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/sale/sale-property/nav']); ?>
<?php
$url_name = request()->route()->getName();
?>
<nav class="navigation-bar">
    <a href="{{route('company.sale.sale-property.essential',['id'=>$id ?? 0])}}"
       @if($url_name == 'company.sale.sale-property.essential') class="active" @endif>基本信息</a>
    <a href="{{route('company.sale.sale-property.building',['id'=>$id ?? 0])}}"
       @if($url_name == 'company.sale.sale-property.building') class="active" @endif>建筑信息</a>
    <a href="{{route('company.sale.sale-property.property',['id'=>$id ?? 0])}}"
       @if($url_name == 'company.sale.sale-property.property') class="active" @endif>物业信息</a>
    <a href="{{route('company.sale.sale-property.sales',['id'=>$id ?? 0])}}"
       @if($url_name == 'company.sale.sale-property.sales') class="active" @endif>销售信息</a>
    <a href="{{route('company.sale.sale-property.follow',['id'=>$id ?? 0])}}"
       @if($url_name == 'company.sale.sale-property.follow') class="active" @endif>跟进信息</a>
    <a href="{{route('company.sale.sale-property.other',['id'=>$id ?? 0])}}"
       @if($url_name == 'company.sale.sale-property.other') class="active" @endif>其他信息</a>
</nav>