<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
      <meta name="csrf-token" content="{{ csrf_token() }}">
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
      <script src="http://cdn.bootcss.com/respond.../js/1.4.2/respond.min.js"></script>
      <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="../images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$goodscount}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(../images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
       <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" id="allbox"/> 全选</a></td>
       </tr>
          @foreach($goodsInfo as $k=>$v)
       <tr goods_id="{{$v->goods_id}}" goods_num="{{$v->goods_num}}">
        <td width="4%"><input type="checkbox" name="1" class="box"/></td>
        <td class="dingimg" width="15%"><img src="http://goods.img.com/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
        </td>
        <td align="right"  self_price="{{$v->self_price}}">
            <input type="text" buy_number="{{$v->buy_number}}" class="spinnerExample" />
        </td>
       </tr>
       <tr>
        <th colspan="4">¥<strong class="pricese orange">{{$v->self_price*$v->buy_number}}</strong></th>
       </tr>
        @endforeach
      </table>
     </div><!--dingdanlist/-->
     
     <div class="dingdanlist">

     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="priceall">¥0</strong></td>
       <td width="40%"><a href="javascript:;" id="jiesuan" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/style.js"></script>
    <!--jq加减-->
    <script src="../js/jquery.spinner.js"></script>
    <script src="/layui/layui.js"></script>
   <script>
	$('.spinnerExample').spinner({});
    $(function(){
        layui.use('layer',function(){
            //购买数量
            var spinnerExample=$('.spinnerExample');
            spinnerExample.each(function(index){
                var buy_number=$(this).attr('buy_number');
                $(this).val(buy_number);
            })

            //点击复选框
            $(document).on('click','.box',function(){
                priceall();
            })
            //总价格
            function priceall(){
                var box=$('.box');
                var goods_id='';
                box.each(function(index){
                    if($(this).prop('checked')==true){
                        goods_id+=$(this).parents('tr').attr('goods_id')+',';
                    }
                });
                // console.log(goods_id);
                goods_id=goods_id.substr(0,goods_id.length-1);
                // console.log(goods_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/cart/priceall",
                    {goods_id:goods_id},
                    function(res){
                        $('#priceall').text('￥'+res);
                        // console.log(res);
                    }
                )
            }
            //点击加号
            $(document).on('click','.increase',function(){
                var _this=$(this);
                var goods_id=_this.parents('tr').attr('goods_id');
                var goods_num=_this.parents('tr').attr('goods_num');
                var buy_number=_this.prev('input').val();
                // console.log(spinnerExample);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    '/cart/changprice',
                    {goods_id:goods_id,buy_number:buy_number},
                    function(res){
                        var self_price=parseInt(_this.parents("td").attr('self_price'));
                        var total=self_price*buy_number;
                        _this.parents("tr").next('tr').find('strong').text(total);
                        priceall();
                    }
                )
            })
            //点击减号
            $(document).on('click','.decrease',function(){
                var _this=$(this);
                var goods_id=_this.parents('tr').attr('goods_id');
                var goods_num=_this.parents('tr').attr('goods_num');
                var buy_number=_this.next('input').val();
                // console.log(spinnerExample);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    '/cart/changprice',
                    {goods_id:goods_id,buy_number:buy_number},
                    function(res){
                        var self_price=parseInt(_this.parents("td").attr('self_price'));
                        var total=self_price*buy_number;
                        _this.parents("tr").next('tr').find('strong').text(total);
                        priceall();
                    }
                )
            })
            //全选
            $('#allbox').click(function(){
                var _this=$(this);
                var status=_this.prop('checked');
                $('.box').prop('checked',status);
                priceall();
            })
            //点击结算
            $('#jiesuan').click(function(){
                var _box=$('.box');
                var goods_id='';
                _box.each(function(index){
                    if($(this).prop('checked')==true){
                        goods_id+=$(this).parents('tr').attr('goods_id')+',';
                    }
                })
                if(goods_id==''){
                    layer.msg('请至少选择一个商品');
                    return false;
                }
                goods_id=goods_id.substr(0,goods_id.length-1);
                // console.log(goods_id);
                location.href="/order/orderlist/"+goods_id;
            })
        })
    })
	</script>
  </body>
</html>