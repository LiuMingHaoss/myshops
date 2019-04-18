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
<form action="/list" >
    <input type="text" name="goods_name" placeholder="名称搜索">
    <input type="text" name="goods_desc" placeholder="详情搜索">
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <th>商品id</th>
        <th>商品名称</th>
        <th>商品图片</th>
        <th>商品数量</th>
        <th>商品描述</th>
        <th>操作</th>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td><img src="http://goods.img.com/{{$v->goods_img}}" alt="" width="40" height="40"></td>
        <td>{{$v->goods_num}}</td>
        <td>{{$v->goods_desc}}</td>
        <td>
            <a href="/desc/{{$v->goods_id}}">详情</a>
            <a href="/del/{{$v->goods_id}}">删除</a>
            <a href="/update/{{$v->goods_id}}">修改</a>
        </td>
    </tr>
        @endforeach
</table>
{{ $data->links()}}
</body>
</html>