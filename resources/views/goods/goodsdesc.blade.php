<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr>
        <td>商品id</td>
        <td>{{$goodsInfo->goods_id}}</td>
    </tr>
    <tr>
        <td>商品名称</td>
        <td>{{$goodsInfo->goods_name}}</td>
    </tr>
    <tr>
        <td>商品图片</td>
        <td><img src="http://goods.img.com/{{$goodsInfo->goods_img}}" alt="" width="40" height="40"></td>
    </tr>
    <tr>
        <td>商品数量</td>
        <td>{{$goodsInfo->goods_num}}</td>
    </tr>
    <tr>
        <td>商品描述</td>
        <td>{{$goodsInfo->goods_desc}}</td>
    </tr>
</table>
</body>
</html>