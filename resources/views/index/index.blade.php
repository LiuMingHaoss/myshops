<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Author" contect="http://www.webqin.net">
	<title>三级分销</title>
	<link rel="shortcut icon" href="../images/favicon.ico" />

	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link href="../css/response.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="maincont">
	<div class="head-top">
		<img src="../images/head.jpg" />
		<dl>
			<dt><a href="user.html"><img src="../images/touxiang.jpg" /></a></dt>
			<dd>
				<h1 class="username">三级分销终身荣誉会员</h1>
				<ul>
					<li><a href="prolist.html"><strong>34</strong><p>全部商品</p></a></li>
					<li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
					<li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
					<div class="clearfix"></div>
				</ul>
			</dd>
			<div class="clearfix"></div>
		</dl>
	</div><!--head-top/-->
	<form action="#" method="get" class="search">
		<input type="text" class="seaText fl" />
		<input type="submit" value="搜索" class="seaSub fr" />
	</form><!--search/-->

	<div id="sliderA" class="slider" >
		@foreach($goodsInfo as $key=>$val)
		<img src="http://goods.img.com/{{$val->goods_img}}" />
@endforeach
	</div><!--sliderA/-->
	<ul class="pronav">
		<li><a href="prolist.html">手机数码</a></li>
		<li><a href="prolist.html">电脑办公</a></li>
		<li><a href="prolist.html">精品男装</a></li>
		<li><a href="prolist.html">家用电器</a></li>
		<div class="clearfix"></div>
	</ul><!--pronav/-->
	<div class="index-pro1">
		@foreach($goodsInfo as $k=>$v)
		<div class="index-pro1-list">

			<dl>
				<dt><a href="/goods/goodsdesc/{{$v->goods_id}}"><img src="http://goods.img.com/{{$v->goods_img}}" /></a></dt>
				<dd class="ip-text"><a href="/goods/goodsdesc/{{$v->goods_id}}">{{$v->goods_name}}</a><span>库存：{{$v->goods_num}}</span></dd>
				<dd class="ip-price"><strong>¥{{$v->self_price}}</strong> <span>¥{{$v->market_price}}</span></dd>
			</dl>

		</div>
		@endforeach


		<div class="clearfix"></div>
	</div><!--index-pro1/-->


	<div class="height1"></div>
	<div class="footNav">
		<dl>
			<a href="/index/index">
				<dt><span class="glyphicon glyphicon-home"></span></dt>
				<dd>微店</dd>
			</a>
		</dl>
		<dl>
			<a href="/goods/allshops">
				<dt><span class="glyphicon glyphicon-th"></span></dt>
				<dd>所有商品</dd>
			</a>
		</dl>
		<dl>
			<a href="/cart/shopcart">
				<dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
				<dd>购物车 </dd>
			</a>
		</dl>
		<dl>
			<a href="/user/userpage">
				<dt><span class="glyphicon glyphicon-user"></span></dt>
				<dd>我的</dd>
			</a>
		</dl>
		<div class="clearfix"></div>
	</div><!--footNav/-->
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/style.js"></script>
<!--焦点轮换-->
<script src="../js/jquery.excoloSlider.js"></script>
<script>
	$(function () {
		$("#sliderA").excoloSlider();
	});
</script>
</body>
</html>