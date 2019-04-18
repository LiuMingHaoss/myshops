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
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
      <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
      <script src="/layui/layui.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员登录</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="../images/head.jpg" />
     </div><!--head-top/-->
     <form action="" method="" class="reg-login">
         @csrf
      <h3>还没有三级分销账号？点此<a class="orange" href="reg.html">注册</a></h3>
      <div class="lrBox">
       <div class="lrList">
           <input type="text" placeholder="请输入邮箱号码" id="user_email"/>
       </div>
       <div class="lrList">
           <input type="password" placeholder="请输入密码" id="user_pwd"/>
       </div>
      </div><!--lrBox/-->
      <div class="lrSub">
          <input type="button" value="立即登录" id="btn"/>
      </div>
     </form><!--reg-login/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="user.html">
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
    <script src="/layui/layui.js"></script>
  </body>
</html>
<script>

    $(function(){
        layui.use('layer',function(){
            $(document).on('click','#btn',function(){
                var user_email=$('#user_email').val();
                var user_pwd=$('#user_pwd').val();
                if(user_email==''){
                    layer.msg('用户名不能为空');
                    return false;
                }
                if(user_pwd==''){
                    layer.msg('密码不能为空');
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    '/login/logindo',
                    {user_email:user_email,user_pwd:user_pwd},
                    function(res){
                        // console.log(res);
                        layer.msg(res.font);
                        if(res.code==2){
                            return false;
                        }else{
                            location.href="/user/userpage";
                        }
                    },'json'
                )
            })
        })

    })
</script>
