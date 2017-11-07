<html>
    <head>
        <title>错误页面</title>


        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
                margin-bottom: 40px;
            }

            .quote {
                font-size: 24px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">小安遇到了点问题</div>
                <div>[{{$code}}]{{$msg}}</div>
                <div style="color:#FFF">{{$file}}</div>
                <div class="quote"></div>
            </div>
        </div>
    </body>
</html>
