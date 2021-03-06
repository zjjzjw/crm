<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="yes" name="apple-touch-fullscreen"/>
    <meta content="telephone=no,email=no" name="format-detection"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title>{!! $meta_title or ''!!}</title>
    <link href="{!! isset($host) ? $host : ''!!}/common.css" rel="stylesheet"/>

    @if (isset($file_css) && $file_css)
        <style></style>
        <link href="{!! isset($host) ? $host : ''!!}/{!!$file_css!!}{!!Huifang\Web\Http\Controllers\Resource::getSuffix('css')!!}.css"
              rel="stylesheet"/>
    @endif

    <script src="{!! isset($host) ? $host : ''!!}/js/lib/require.js"></script>
    <script src="{!! isset($host) ? $host : ''!!}/common.js"></script>
</head>
<body>
<?php
//dd($debug);
?>
{{-- add common page params --}}
<?php Huifang\Web\Http\Controllers\Resource::addParam(array('logServer' => $log_server, 'logParams' => $log_params, 'pageParams' => empty($page_params) ? [] : ['page_param' => $page_params]));?>
<div class="page">
    @section('navbar')
        @include('partials.navbar')
    @show

    {{-- content --}}
    <div class="content-wrapper">
        @yield('content')
    </div>
    <div class="network-status"></div>
</div>


{!! ($debug) ? Huifang\Web\Http\Controllers\Resource::autoGenerate($file_js, $file_css) : ''!!}

@if ($base_url)
    <script type="text/javascript">
        require.config({
            @if ($debug)
            waitSeconds: 0,
            urlArgs: "v=" + (new Date()).getTime(),
            @endif
            baseUrl: '{!!$base_url!!}'
        });
        require(['common'], function () {
        });

        define('page.params', function () {
            return {!!json_encode( Huifang\Web\Http\Controllers\Resource::getAllParams())!!};
        });

    </script>
@endif
@if (isset($file_js) && $file_js)
    <script src="{!! isset($host) ? $host : ''!!}/{!!$file_js!!}{!!Huifang\Web\Http\Controllers\Resource::getSuffix('js')!!}.js"></script>
@endif
</body>
</html>
