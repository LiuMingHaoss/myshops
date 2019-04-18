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
<form action="/updatedo" method="post">
<table border="1">
    <input type="hidden" name="goods_id" value="{{$goodsInfo->goods_id}}">
    <tr>
        <td>商品名称</td>
        <td><input type="text" name="goods_name" value="{{$goodsInfo->goods_name}}"></td>
    </tr>
    <tr>
        <td>商品图片</td>
        <td><input type="file"><img src="http://goods.img.com/{{$goodsInfo->goods_img}}" alt="" width="40" height="40"></td>
    </tr>
    <tr>
        <td>商品数量</td>
        <td><input type="text" name="goods_num" value="{{$goodsInfo->goods_num}}"></td>
    </tr>
    <tr>
        <td>商品描述</td>
        <td><textarea name="goods_desc" id="" cols="30" rows="10">
                {{$goodsInfo->goods_desc}}
            </textarea></td>
    </tr>
    <tr>
        <td><input type="submit" value="修改"></td>
    </tr>
</table>
</form>
</body>
</html>