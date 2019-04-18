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
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/images/head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><a href="/address/addressadd" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
            <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
        </tr>
    </table>

    <div class="dingdanlist" onClick="window.location.href='javascript:;'" >
        @foreach($addressInfo as $k=>$v)
            @if($v->is_default==1)
        <table style="background-color:greenyellow;">
            @else
                <table >
            @endif
            <tr>
                <td width="50%">
                    <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
                    <time>{{$v->province->name}}{{$v->city->name}}{{$v->area->name}}{{$v->address_detail}}</time>
                </td>
                <td align="right" address_id="{{$v->address_id}}">
                    @if($v->is_default!=1)
                    <a href="javascript:;" class="is_default hui"  style="color:orangered">设为默认</a>
                    @endif
                    <a href="javascript:;" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
            </tr>
        </table>
        @endforeach
    </div><!--dingdanlist/-->

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
        <dl class="ftnavCur">
            <a href="/user/userpage">
                <dt><span class="glyphicon glyphicon-user"></span></dt>
                <dd>我的</dd>
            </a>
        </dl>
        <div class="clearfix"></div>
    </div><!--footNav/-->
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
            $(document).on('click','.is_default',function(){
                var _this=$(this);
                var address_id=_this.parent().attr('address_id');
                $.post(
                    '/address/default',
                    {address_id:address_id},
                    function(res){
                        layer.msg(res.font);
                        history.go(0);
                    },'json'
                )
            })
        })
    })
</script>
</body>
</html>