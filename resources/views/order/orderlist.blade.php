<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
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
      <img src="/images/head.jpg" />
     </div><!--head-top/-->
     <div class="dingdanlist" onClick="window.location.href='javascript:;'">
         <b style="color:darkmagenta">请选择收货地址</b>
         <div style="border:1px solid darkgray;overflow:auto;height:100px;">
          @foreach($addressInfo as $k=>$v)
             <table >
                <tr >
                    @if($v->is_default==1)
                    <td  rowspan="2"><input type="radio" name="is_default" value="{{$v->address_id}}" checked></td>
                        @else
                        <td  rowspan="2"><input type="radio" name="is_default" value="{{$v->address_id}}"></td>
                        @endif
                </tr>
                 <tr>
                     <td >
                         <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
                         <time>{{$v->province->name}}{{$v->city->name}}{{$v->area->name}}{{$v->address_detail}}</time>
                     </td>
                     <td align="right"><a href="address.html" class="hui" style="color:blueviolet"></a></td>
                 </tr>
             </table>
         @endforeach
         </div>
        <table>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <b style="color:darkmagenta">支付方式</b>
       <tr>
        <td colspan="2">
            <input type="radio" name="pay" class="pay" pay_type="1" checked>支付宝
            <input type="radio" name="pay" class="pay" pay_type="2">余额
            <input type="radio" name="pay" class="pay" pay_type="3">货到付款
        </td>

       </tr>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>

       <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="3" style="color:darkmagenta">商品清单</td>
       </tr>
       @foreach($cartInfo as $k=>$v)
       <tr goods_id="{{$v->goods_id}}" class="goods_id">
        <td class="dingimg" width="15%"><img src="http://goods.img.com/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>{{$v->goods_desc}}</time>
        </td>
        <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
       </tr>
       <tr>
        <th colspan="3"><strong class="orange">¥{{$v->buy_number*$v->self_price}}</strong></th>
       </tr>
        @endforeach
       
       {{--<tr>--}}
        {{--<td class="dingimg" width="75%" colspan="2">商品金额</td>--}}
        {{--<td align="right"><strong class="orange">¥68.80</strong></td>--}}
       {{--</tr>--}}
       {{--<tr>--}}
        {{--<td class="dingimg" width="75%" colspan="2">折扣优惠</td>--}}
        {{--<td align="right"><strong class="green">¥0.00</strong></td>--}}
       {{--</tr>--}}
       {{--<tr>--}}
        {{--<td class="dingimg" width="75%" colspan="2">抵扣金额</td>--}}
        {{--<td align="right"><strong class="green">¥0.00</strong></td>--}}
       {{--</tr>--}}

       <tr>

        <td class="dingimg" width="75%" colspan="2"> <b style="color:darkmagenta">订单留言</b><br>
            <textarea name="" id="order_text" cols="40" rows="5"></textarea></td>

       </tr>

      </table>
     </div><!--dingdanlist/-->
     
     
    </div><!--content/-->
    
    <div class="height1"></div>
    <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥{{$pricecount}}</strong></td>
       <td width="40%"><a href="javascript:;" class="jiesuan" id="jiesuan">提交订单</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/style.js"></script>
    <!--jq加减-->
    <script src="/js/jquery.spinner.js"></script>
    <script src="/layui/layui.js"></script>

    <script>
	$('.spinnerExample').spinner({});
	$(function(){
	    layui.use('layer',function(){
            $('#jiesuan').click(function(){
                //获取商品信息
                var _tr=$('.goods_id');
                var goods_id='';
                _tr.each(function(index){
                    goods_id+=$(this).attr('goods_id')+',';
                })
                goods_id=goods_id.substr(0,goods_id.length-1);
                //获取收货信息
                var address_id='';
                $('input[name=is_default]').each(function(index){
                    if($(this).prop('checked')==true){
                        address_id=$(this).val();
                    }
                })
                //获取支付方式
                var pay=$('.pay');
                var pay_type='';
                pay.each(function(index){
                    if($(this).prop('checked')==true){
                        pay_type=$(this).attr('pay_type');
                    }
                })
                //订单留言
                var order_text=$('#order_text').val();
                // console.log(order_text);
                //提交订单
                $.post(
                    '/order/suborder',
                    {goods_id:goods_id,address_id:address_id,pay_type:pay_type,order_text:order_text},
                    function(res){
                        layer.msg(res.font);
                        if(res.code==1){
                            location.href="/order/orderpay";
                        }
                    },'json'
                )
            })
        })
    })
	</script>
  </body>
</html>