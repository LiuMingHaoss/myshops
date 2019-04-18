<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    //收货地址
    public function address(){
        $where=[
            'user_id'=>session('user.user_id'),
            'address_status'=>1
        ];
        //查询当前用户收货地址
        $addressInfo=DB::table('shop_address')->where($where)->get()->toArray();
//        var_dump($addressInfo);
        foreach($addressInfo as $k=>$v){
            $addressInfo[$k]->province=DB::table('shop_area')->where('id',$v->province)->first('name');
            $addressInfo[$k]->city=DB::table('shop_area')->where('id',$v->city)->first('name');
            $addressInfo[$k]->area=DB::table('shop_area')->where('id',$v->area)->first('name');
        }
//        var_dump($addressInfo);
        return view('address/address',['addressInfo'=>$addressInfo]);
    }
    //收货地址添加
    public function addressadd(){
        //获取省份信息
        $province=DB::table('shop_area')->where('pid',0)->get();
//        var_dump($res);
        return view('address/addressadd',['province'=>$province]);
    }
    //执行添加
    public function addressadddo(Request $request){
        $data=$request->input();
        $data['user_id']=session('user.user_id');
        if($data['is_default']==1){
            DB::beginTransaction();
            $res1=DB::table('shop_address')->update(['is_default' => 2]);
            $res2=DB::table('shop_address')->insert($data);
            if($res1!==false&$res2!==false){
                DB::commit();
                echo json_encode(['font'=>'添加成功','code'=>1]);
            }else{
                DB::rollBack();
                echo json_encode(['font'=>'添加失败','code'=>2]);
            }
        }else{
            $res=DB::table('shop_address')->insert($data);
            if($res){
                echo json_encode(['font'=>'添加成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'添加失败','code'=>2]);
            }
        }

    }
    //省市区
    public function area(Request $request){
        $id=$request->input('id');
        $res=DB::table('shop_area')->where('pid',$id)->get();
//        var_dump($res);
        echo json_encode(['areaInfo'=>$res,'code'=>1]);
    }
    //设置默认
    public function default(Request $request){
        $address_id=$request->input('address_id');
//        dd($address_id);
        $where=[
            'user_id'=>session('user.user_id'),
        ];
        $where2=[
            'user_id'=>session('user.user_id'),
            'address_id'=>$address_id
        ];
        DB::beginTransaction();
        $res1=DB::table('shop_address')->where($where)->update(['is_default' => 2]);
        $res2=DB::table('shop_address')->where($where2)->update(['is_default' => 1]);
        if($res1!==false&$res2!==false){
            DB::commit();
            echo json_encode(['font'=>'设置成功','code'=>1]);
        }else{
            DB::rollBack();
            echo json_encode(['font'=>'设置失败','code'=>2]);
        }
    }

}
