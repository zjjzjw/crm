<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>未接通报表数据</title>
    <style>
        html, body {
            height: 100%;
        }

        .content {
            margin-top: 50px;
            margin-left: 10px;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <table border="1" bordercolor="#a0c6e5" style="border-collapse:collapse;text-aligin:center;width: 100%;">
            <tr class="center" style="font-size: 15px;">
                <th width="120">客户手机号</th>
                <th width="120">顾问名字</th>
                <th width="120">楼盘名字</th>
                <th width="120">拨号时间</th>
            </tr>
            @foreach($data as $v)
            <tr class="center">
                <td>{{$v['originating_call']}}</td>
                <td>{{$v['account_name']}}</td>
                <td>{{$v['loupan_name']}}</td>
                <td>{{$v['start_time']}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>