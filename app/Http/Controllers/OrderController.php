<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\Weixin\WXBizDataCryptController;
class OrderController extends Controller
{
    public $weixin_unifiedorder_url='https://api.mch.weixin.qq.com/pay/unifiedorder';   //统一下单接口
    public $notify_url='http://1809liuminghao.comcto.com/weixin/pay/notify';    //支付回调

    //订单列表
    public function orderlist($id){
        //获取商品信息
        $goodswhere=[
            'user_id'=>session('user.user_id'),
            'cart_status'=>1,
        ];
        $id=explode(',',$id);
        $Info = DB::table('shop_cart')
            ->join('shop_goods', 'shop_cart.goods_id', '=', 'shop_goods.goods_id')
            ->where($goodswhere)
            ->whereIn('shop_cart.goods_id',$id)
            ->get();
//        var_dump($Info);die;
        //查询当前用户收货地址
        $where=[
            'user_id'=>session('user.user_id'),
            'address_status'=>1,

        ];
        $addressInfo=DB::table('shop_address')->where($where)->get()->toArray();
//        var_dump($addressInfo);
        foreach($addressInfo as $k=>$v){
            $addressInfo[$k]->province=DB::table('shop_area')->where('id',$v->province)->first('name');
            $addressInfo[$k]->city=DB::table('shop_area')->where('id',$v->city)->first('name');
            $addressInfo[$k]->area=DB::table('shop_area')->where('id',$v->area)->first('name');
        }
        //获取总价格
        if(!empty($Info)){
            $priceCount=0;
            foreach($Info as $k=>$v){
                $priceCount+=$v->buy_number*$v->self_price;
            }
        }

        return view('order/orderlist',['addressInfo'=>$addressInfo,'cartInfo'=>$Info,'pricecount'=>$priceCount]);
    }
    //提交订单
    public function suborder(Request $request){
        $goods_id=$request->input('goods_id');
        $goods_id=explode(',',$goods_id);
        $address_id=$request->input('address_id');
        $pay_type=$request->input('pay_type');
        $order_text=$request->input('order_text');
        //
        DB::beginTransaction();
        //添加订单表
        $priceCount=$this->priceCount($goods_id);
//        dd($priceCount);
        $orderInfo=[
            'order_no'=>time().rand(100000,999999),
            'user_id'=>session('user.user_id'),
            'order_amount'=>$priceCount,
            'pay_type'=>$pay_type,
            'create_time'=>time(),
            'order_text'=>$order_text
        ];
        $order_id=DB::table('shop_order')->insertGetId($orderInfo);
//        dd($res1);
        //添加订单商品表
        $goodswhere=[
            'user_id'=>session('user.user_id'),
            'cart_status'=>1,
        ];
//        dd($goodswhere);
        $goodsInfo = DB::table('shop_cart')
            ->join('shop_goods', 'shop_cart.goods_id', '=', 'shop_goods.goods_id')
            ->where($goodswhere)
            ->whereIn('shop_cart.goods_id',$goods_id)
            ->get()
            ->toArray();
        $goodsorder=[];
        $goodsorder=$this->goodsorder($goodsInfo,$order_id);
        $res2=DB::table('shop_order_detail')->insert($goodsorder);
//        var_dump($goodsorder);die;
        //添加订单地址表
        $addresswhere=[
          'address_id'=>$address_id
        ];
        $addressInfo=DB::table('shop_address')->where($addresswhere)->first();
        $addressInfo->order_id=$order_id;
        unset($addressInfo->is_default);
        unset($addressInfo->address_status);
        unset($addressInfo->address_id);
        $addInfo=[];
        foreach($addressInfo as $k=>$v){
            $addInfo[$k]=$v;
        }
        $res3=DB::table('shop_order_address')->insert($addInfo);
//        print_r($addInfo);die;
        //清除购物车
        $res4=DB::table('shop_cart')
            ->where('user_id',session('user.user_id'))
            ->whereIn('goods_id',$goods_id)
            ->update(['cart_status'=>2]);
        //减少库存
//        dd($goodsInfo);
        foreach($goodsInfo as $k=>$v){
            $goodsWhere=[
                'goods_id'=>$v->goods_id
            ];
            $updateInfo=[
                'goods_num'=>$v->goods_num-$v->buy_number
            ];
            $res5=DB::table('shop_goods')->where($goodsWhere)->update($updateInfo);
        }
        if($res2&&$res3&&$res4&&$res5){
            DB::commit();
            session(['order_id'=>$order_id]);
            echo json_encode(['font'=>'下单成功','code'=>1]);
        }else{
            DB::rollBack();
            echo json_encode(['font'=>'下单失败','code'=>2]);
        }
    }
    //获取总价格
    public function priceCount($goods_id){
        $goodswhere=[
            'user_id'=>session('user.user_id'),
            'cart_status'=>1,
        ];
//        dd($goodswhere);
        $Info = DB::table('shop_cart')
            ->join('shop_goods', 'shop_cart.goods_id', '=', 'shop_goods.goods_id')
            ->where($goodswhere)
            ->whereIn('shop_cart.goods_id',$goods_id)
            ->get();
//        dd($Info);
        if(!empty($Info)){
            $priceCount=0;
            foreach($Info as $k=>$v){
                $priceCount+=$v->buy_number*$v->self_price;
            }
        }
        return $priceCount;
    }
    //支付页面
    public function orderpay(){
        $order_id=session('order_id');
//        dd($order_id);
        $res=DB::table('shop_order')->where('order_id',$order_id)->first();
        $res->create_time=date('Y-m-d H:i:s',$res->create_time);
        return view('order/orderpay',['pay'=>$res]);
    }
    //添加订单商品信息
    public function goodsorder($goodsInfo,$order_id){
        foreach($goodsInfo as $k=>$v){
//            var_dump($v);die;
            $goodsInfo[$k]->order_id=$order_id;
            $goodsInfo[$k]->user_id=session('user.user_id');
            $goodsInfo[$k]->goods_price=$v->self_price*$v->buy_number;
            foreach($v as $key=>$val){
                $goodsorder[$k][$key]=$val;
                unset($goodsorder[$k]['cart_status']);
                unset($goodsorder[$k]['is_new']);
                unset($goodsorder[$k]['is_best']);
                unset($goodsorder[$k]['is_hot']);
                unset($goodsorder[$k]['is_up']);
                unset($goodsorder[$k]['goods_imgs']);
                unset($goodsorder[$k]['goods_num']);
                unset($goodsorder[$k]['self_price']);
                unset($goodsorder[$k]['market_price']);
                unset($goodsorder[$k]['cart_id']);
                unset($goodsorder[$k]['goods_desc']);
                unset($goodsorder[$k]['goods_score']);
                unset($goodsorder[$k]['brand_id']);
                unset($goodsorder[$k]['cate_id']);
                $goodsorder[$k]['create_time']=time();
            }
        }
        return $goodsorder;
    }
    //立即支付
    public function paygo($order_no){
        $orderInfo=DB::table('shop_order')->select(['order_amount','order_no'])->where('order_no',$order_no)->first();
//        dd($orderInfo);
//        echo app_path('alipaywap/wappay/service/AlipayTradeService.php');die;
        require_once app_path('alipaywap/wappay/service/AlipayTradeService.php');
        require_once app_path('alipaywap/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php');
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $orderInfo->order_no;

        //订单名称，必填
        $subject = '请付款';

        //付款金额，必填
        $total_amount = $orderInfo->order_amount;

        //商品描述，可空
        $body = '';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService(config('alipay'));
        $result=$payResponse->wapPay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));

        return ;
    }
    //同步跳转
    public function returnpay(){
        echo '支付ok';
    }
    //异步跳转
    public function notifypay(Request $request){
       $arr=$_POST;
       dd($arr);
        Log::channel('alipay')->info($arr);

    }

    //微信支付
    public function paygo_wx($order_no){
        $total_fee = 1;     //用户需要支付的总金额
        $order_id=time().'liuminghao'.mt_rand(10000,99999);  //随机生成测试订单号
        $order_info = [
            'appid'         => env('WEIXIN_APPID_0'),     //微信支付绑定的服务号的APPID
            'mch_id'        => env('WEIXIN_MCH_ID'),     //商户id
            'nonce_str'     => Str::random(16),     //随机字符串
            'sign_type'     => 'MD5',
            'body'          =>'测试订单-'.mt_rand(1111,9999).Str::random(6),
            'out_trade_no'  => $order_no,       //本地订单号
            'total_fee'     => $total_fee,
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],  //客户端IP
            'notify_url'    =>$this->notify_url,    //通知回调地址
            'trade_type'    =>'NATIVE'  //交易类型
        ];
        $this->values=[];
        $this->values=$order_info;
        $this->SetSign();
        $xml = $this->ToXml();  //将数组转换为XML
        $rs = $this->postXmlCurl($xml,$this->weixin_unifiedorder_url,$useCert=false,$second=30);
        $data=simplexml_load_string($rs);
//        echo 'return_code: '.$data->return_code;echo '<br>';
//		echo 'return_msg: '.$data->return_msg;echo '<br>';
//		echo 'appid: '.$data->appid;echo '<br>';
//		echo 'mch_id: '.$data->mch_id;echo '<br>';
//		echo 'nonce_str: '.$data->nonce_str;echo '<br>';
//		echo 'sign: '.$data->sign;echo '<br>';
//		echo 'result_code: '.$data->result_code;echo '<br>';
//		echo 'prepay_id: '.$data->prepay_id;echo '<br>';
//		echo 'trade_type: '.$data->trade_type;echo '<br>';
//        echo 'code_url: '.$data->code_url;echo '<br>';




        $data=[
            'code_url'=>$data->code_url
        ];


        return view('weixin.wx_pay',$data);
    }
    protected function ToXml()
    {
        if(!is_array($this->values)
            || count($this->values) <= 0)
        {
            die("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($this->values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    private  function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		if($useCert == true){
//			//设置证书
//			//使用证书：cert 与 key 分别属于两个.pem文件
//			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
//			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
//		}
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            die("curl出错，错误码:$error");
        }
    }
    public function SetSign()
    {
        $sign = $this->MakeSign();
        $this->values['sign'] = $sign;
        return $sign;
    }
    private function MakeSign()
    {
        //签名步骤一：按字典序排序参数
        ksort($this->values);
        $string = $this->ToUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".env('WEIXIN_MCH_KEY');
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    /**
     * 格式化参数格式化成url参数
     */
    protected function ToUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    public function notify()
    {
        $data = file_get_contents("php://input");
        //记录日志
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents('logs/wx_pay_notice.log',$log_str,FILE_APPEND);
        $xml = simplexml_load_string($data);
        if($xml->result_code=='SUCCESS' && $xml->return_code=='SUCCESS'){      //微信支付成功回调
            //验证签名
            $sign = true;
            if($sign){       //签名验证成功
                //TODO 逻辑处理  订单状态更新
                $res=DB::table('shop_order')->where('order_no',$xml->out_trade_no)->update(['pay_status'=>2]);
                if($res){
                    return redirect('/pay_go_do');
                }
            }else{
                //TODO 验签失败
                echo '验签失败，IP: '.$_SERVER['REMOTE_ADDR'];
                // TODO 记录日志
            }
        }
        $response = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        echo $response;
    }
    public function pay_go_do(){
        echo '支付成功';
    }
}
