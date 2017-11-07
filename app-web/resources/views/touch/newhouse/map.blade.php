<!-- 房源地图页 -->
<?php Xinfang\Web\Http\Controllers\Resource::addJS(array('app/map-loupan'));?>
<?php Xinfang\Web\Http\Controllers\Resource::addCSS(array('css/newhouse/map-loupan'));?>
<?php Xinfang\Web\Http\Controllers\Resource::addParam(array('lng' => $result['lng'], 'lat' => $result['lat']));?>
@extends('layouts.touch')
@section('content')
@if (!empty($result) && !empty($bmap_ak))
    @if(!empty($result['address']))
        <p class="addr h4 txt-primary">
            <span>地址：</span><span>{{$result['address']}}</span>
        </p>
    @endif
    @if(!empty($result['lng']) && !empty($result['lat']))
        <div id="map" style="height: 90%">
        </div>
    @endif
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=43d4bbd0927a02280dcd5a3de5499f29"></script>
@endif
@endsection
