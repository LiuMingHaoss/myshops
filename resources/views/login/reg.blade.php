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
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/images/head.jpg" />
     </div><!--head-top/-->
     <form action="" method="" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="login.html">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" id="user_email" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" id="code" placeholder="输入短信验证码" />
           <a href="javascript:;" id="sendemail">获取验证码</a>
         </div>
       <div class="lrList"><input type="password" id="user_pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" id="user_repwd" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" id="btn" value="立即注册" />
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
    <script src="/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/style.js"></script>
    <script src="/layui/layui.js"></script>

  </body>
</html>
<script>
    $(function(){
        layui.use('layer',function(){
            //点击获取
            $(document).on('click','#sendemail',function(){
                var user_email=$('#user_email').val();
                var emailFlag=false;
                //验证非空
                var reg=/^\w+@\w+\.com$/;
                if(user_email==''){
                    layer.msg('邮箱不能为空',{icon:2});
                    return false;
                }else if(!reg.test(user_email)){
                    layer.msg('请输入正确邮箱格式',{icon:2});
                    return false;
                }else {
                    //验证邮箱唯一性
                    $.ajax({
                        type: 'post',
                        url: "/login/checkemail",
                        data: {user_email: user_email},
                        asunc: false,
                        success: function (res) {
                            // console.log(res);
                            if(res.code==2){
                                layer.msg(res.font,{icon:res.code});
                                emailFlag=false;
                            }else{
                                emailFlag=true;
                            }
                        },
                        dataType: 'json'
                    })
                    if(emailFlag=false){
                        return emailFlag;
                    }
                }
                // return false;
                $.get(
                    '/login/sendemail',
                    {user_email:user_email},
                    function(res){
                        layer.msg(res.font);
                    }
                )
            })
            //点击注册
            $(document).on('click','#btn',function(){
                var user_email=$('#user_email').val();
                var code=$('#code').val();
                var user_pwd=$('#user_pwd').val();
                var user_repwd=$('#user_repwd').val();
                var reg=/^\w{6,}$/;
                if(user_email==''){
                    layer.msg('邮箱必填',{icon:2});
                    return false;
                }
                if(code==''){
                    layer.msg('验证码必填',{icon:2});
                    return false;
                }
                if(user_pwd==''){
                    layer.msg('密码必填',{icon:2});
                    return false;
                }else if(!reg.test(user_pwd)){
                    layer.msg('密码必须六位以上 ',{icon:2});
                    return false;
                }
                //确认密码
                if(user_repwd==''){
                    layer.msg('确认密码必填',{icon:2});
                    return false;
                }else if(user_repwd!=user_pwd){
                    layer.msg('确认密码和密码不一致 ',{icon:2});
                    return false;
                }
                //注册提交
                $.post(
                    "/login/regdo",
                    {user_email:user_email,user_pwd:user_pwd,user_code:code},
                    function(res){
                        // console.log(res);
                        layer.msg(res.font,{icon:res.code});
                        if(res.code==1){
                            location.href="/login/login";
                        }
                    },'json'
                )
            })
        })
    })
</script>
