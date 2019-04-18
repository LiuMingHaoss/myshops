<div>微信支付二维码</div>
<div id="qrcode"></div>
<script src="/js/jquery/jquery-1.12.4.min.js"></script>
<script src="/js/weixin/qrcode.js"></script>
<script type="text/javascript">
    new QRCode(document.getElementById("qrcode"), "{{$code_url}}");
</script>