<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;
class GoodsController extends Controller
{
    //商品列表
    public function goodslist(){
        $seach=request()->input();
        $where[]=['status',1];
        if($seach['goods_name']??''){
            $where[]=['goods_name','like',"%$seach[goods_name]%"];
        }
        if($seach['goods_desc']??''){
            $where[]=['goods_desc','like',"%$seach[goods_desc]%"];
        }
        $data=DB::table('shop_goods')->where($where)->paginate(5);
        return view('goods/goodslist',['data'=>$data,'seach'=>$seach]);
    }
    //商品详情
    public function goodsdesc(Request $request,$goods_id){
        $where=[
          'goods_id'=>$goods_id
        ];
        $res=Cache::get('goodsInfo_'.$goods_id);
        var_dump($res);
        if(!$res){
            $res=DB::table('shop_goods')->where($where)->first();
            Cache::put('goodsInfo_'.$goods_id,$res);
        }
        return view('goods/goodsdesc',['goodsInfo'=>$res]);
    }
    //删除
    public function goodsdel($goods_id){
        $where=[
          'goods_id'=>$goods_id
        ];
        $res=DB::table('shop_goods')->where($where)->update(['status'=>2]);
        if($res){
            Cache::forget('goodsInfo_'.$goods_id);
            return redirect('/list');
        }
    }
    //修改
    public function goodsupdate($goods_id){
        $res=DB::table('shop_goods')->where('goods_id',$goods_id)->first();
        return view('goods/goodsupdate',['goodsInfo'=>$res]);
    }
    //修改执行
    public function updatedo(){
        $data=request()->input();
        $where=[
            'goods_id'=>$data['goods_id']
        ];
        $res=DB::table('shop_goods')->where($where)->update($data);
        if($res){
            Cache::put('goodsInfo_'.$data['goods_id'],$data);
            return redirect('/list');
        }
    }
}
