<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="mobile-agent" content="format=html5;url={!!$meta_url or ''!!}">
    <meta id="viewport" name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>{!! $meta_title or '橙诺' !!}</title>
    <meta name="Keywords" content="{!!$meta_keyword or ''!!}"/>
    <meta name="Description" content="{!!$meta_description or ''!!}"/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    @include('styles')

    @if (isset($file_css) && $file_css)
        <style></style>
        <link href="{!! isset($host) ? $host : ''!!}/{!!implode('/', explode('.', $file_css))!!}{!!Huifang\Admin\Http\Controllers\Resource::getSuffix('css')!!}.css"
              rel="stylesheet"/>
    @endif
</head>


<body>
@section('master.header')
    <div class="header">
        @include('partials.topbar', [])
    </div>
@show

<div class="content-wrapper">
    @section('master.sidebar')
        <div class="sidebar">
            @include('partials.sidenav', [$menu_config ?? []])
        </div>
    @show


    <div class="main">
        @section('master.breadcrumbs')
            @if(isset($breadcrumbs))
                @include('partials.breadcrumbs', $breadcrumbs)
            @endif
        @show

        @section('master.title')
            <h3 class="page-header">
                @yield('title', $title ?? '公司管理')
            </h3>
        @show

        @yield('master.content')
    </div>

    @section('master.footer')
        <div class="footer text-center">
        </div>
    @show
</div>


{!! ($debug) ? Huifang\Admin\Http\Controllers\Resource::autoGenerate($file_js, $file_css) : ''!!}

<script src="{!! isset($host) ? $host : ''!!}/js/lib/require.js"></script>
<script src="{!! isset($host) ? $host : ''!!}/js/common.js"></script>
@if ($base_url)
    <script type="text/javascript">
        require.config({
            @if ($debug)
            waitSeconds: 0,
            urlArgs: "v=" + (new Date()).getTime(),
            @endif
            baseUrl: '{!!$base_url!!}'
        });
        define('page.params', function () {
            return {!!json_encode( Huifang\Admin\Http\Controllers\Resource::getAllParams())!!};
        });

    </script>
@endif

@if (isset($file_js) && $file_js)
    <script src="{!! isset($host) ? $host : ''!!}/{!!implode('/', explode('.', $file_js))!!}{!!Huifang\Admin\Http\Controllers\Resource::getSuffix('js')!!}.js"></script>
@endif

</body>
</html>
