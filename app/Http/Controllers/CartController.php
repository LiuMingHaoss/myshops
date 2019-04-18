<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
    //购物车列表
    public function shopcart(){
        //查询购物车信息
        $where=[
            'user_id'=>session('user.user_id'),
            'cart_status'=>1
        ];
        $goodsInfo = DB::table('shop_cart')
            ->join('shop_goods', 'shop_cart.goods_id', '=', 'shop_goods.goods_id')
            ->where($where)
            ->get();
//        var_dump($goodsInfo);
        $goodscount = DB::table('shop_cart')
            ->join('shop_goods', 'shop_cart.goods_id', '=', 'shop_goods.goods_id')
            ->where($where)
            ->count();

        return view('/cart/shopcart',['goodsInfo'=>$goodsInfo,'goodscount'=>$goodscount]);
    }
    //添加购物车
    public function cartdo(Request $request){
        $data=$request->input();
//        dd($data);
        $data['user_id']=session('user.user_id');
//        var_dump($data);die;
        $data['create_time']=time();
        $where=[
          'user_id'=>$data['user_id'],
            'goods_id'=>$data['goods_id'],
            'cart_status'=>1
        ];
        $cartInfo=DB::table('shop_cart')->where($where)->first();
//        var_dump($cartInfo);die;
        if(!empty($cartInfo)){
                $update=[
                    'buy_number'=>$cartInfo->buy_number+$data['buy_number']
                ];
            $res=DB::table('shop_cart')->update($update);
            if($res){
                echo json_encode(['font'=>'加入购物车成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'加入购物车失败','code'=>2]);
            }
        }else{
            $res=DB::table('shop_cart')->insert($data);
            if($res){
                echo json_encode(['font'=>'加入购物车成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'加入购物车失败','code'=>2]);
            }
        }

    }
    //总价格
    public function priceall(Request $request){
        $goods_id=$request->input('goods_id');
//        $goods_id=9;
//        var_dump($goods_id);
        $goods_id=explode(',',$goods_id);
//        var_dump($goods_id);
        $where=[
            'user_id'=>session('user.user_id'),
            'cart_status'=>1,
//            'shop_cart.goods_id'=>['in',$goods_id]
        ];
//        $where['shop_cart.goods_id']=[$goods_id];
//        var_dump($where);die;
        $Info = DB::table('shop_cart')
            ->join('shop_goods', 'shop_cart.goods_id', '=', 'shop_goods.goods_id')
            ->where($where)
            ->whereIn('shop_cart.goods_id',$goods_id)
            ->get();
//        var_dump($Info);
        $countPrice=0;
        foreach($Info as $k=>$v){
//            var_dump($v);die;
            $countPrice+=$v->buy_number*$v->self_price;
        }
        echo $countPrice;
    }
    //小计
    public function changprice(Request $request){
        $data=$request->input();
//        var_dump($data);
        $where=[
            'user_id'=>session('user.user_id'),
            'goods_id'=>$data['goods_id'],
        ];
        $info=[
            'buy_number'=>$data['buy_number'],
        ];
        $res=DB::table('shop_cart')->where($where)->update($info);
    }
}
