<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class OrderController extends Controller
{

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
}
