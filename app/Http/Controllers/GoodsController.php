<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class GoodsController extends Controller
{
    //全部商品
    public function allshops(){
        $goodsInfo=DB::table('shop_goods')->paginate(10);
//        dd($goodsInfo);
        return view('/goods/allshops',['goodsInfo'=>$goodsInfo]);
    }
    //商品详情
    public function goodsdesc($id){
//        echo $id;
        $where=[
            'goods_id'=>$id
        ];
        $res=DB::table('shop_goods')->where($where)->first();
        $goods_imgs=$res->goods_imgs;
        $goods_imgs=explode('|',rtrim($goods_imgs,'|'));

//        var_dump($goods_imgs);
//        var_dump($res);
        return view('goods/goodsdesc',['goodsInfo'=>$res,'goodsimgs'=>$goods_imgs]);
    }
    //重新获取商品
    public function newgoods(){
        $type=request()->input('type');
        if($type==1){
            $where=[
                'is_new'=>1
            ];
        }else if($type==2){
            $where=[
                'is_best'=>1
            ];
        }else if($type==3){
            $where=[
                'is_hot'=>1
            ];
        }
        $res=DB::table('shop_goods')->where($where)->get();
        echo view('goods/div',['goodsInfo'=>$res]);
    }
}
