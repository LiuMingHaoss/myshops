<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/page.css">

    <title>Document</title>
</head>
<body>
<form action="/cms/cmslist" >
    <input type="text" name="goods_name">
    <button>搜索</button>
</form>
<br>
<table border="1">

    <th>名称</th>
    <th>价格</th>
    <th>详情</th>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->self_price}}</td>
        <td>{{$v->goods_desc}}</td>
    </tr>
        @endforeach
</table>
{{ $data->appends($seach)->links() }}
{{--<input type="button" value="清空缓存">--}}
<a href="/alipay/1553171226758734">立即付款</a>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: LiuMH
 * Date: 2019/3/23
 * Time: 9:05
 */