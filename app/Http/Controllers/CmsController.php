<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CmsController extends Controller
{
    //
    public function cmslist(Request $request){
//        Cache::flush();
        $seach=$request->input();
        $goods_name=$request->input('goods_name');
        $page=$request->input('page');
        $data=Cache::get('data_'.$page.'_'.$goods_name);
//        var_dump($data);
        if(!$data){
            $where=[];
            if($seach['goods_name']??''){
                $where[]=['goods_name','like',"%$seach[goods_name]%"];
            }
            $data=DB::table('shop_goods')->where($where)->paginate(2);
            Cache::put('data_'.$page.'_'.$goods_name,$data,1);
        }
        return view('cms/cmslist',['data'=>$data,'seach'=>$seach]);
    }
    public function alipay($orderon){
        if(!$orderon){
            return redirect('/alipay')->with('没有此订单信息');
        }
        //根据订单号获取订单信息 订单金额
        $order=DB::table('shop_order')->select(['order_amount','order_no'])->where('order_no',$orderon)->first();
//        echo app_path('libs/alipay/pagepay/service/AlipayTradeService.php');die;
        require_once  app_path('libs/alipay/pagepay/service/AlipayTradeService.php');
        require_once app_path('libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($orderon);

        //订单名称，必填
        $subject = '刘铭昊测试';

        //付款金额，必填
        $total_amount = trim($order->order_amount);

        //商品描述，可空
        $body = '';

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService(config('alipay'));

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));

        //输出表单
        var_dump($response);
    }
}
