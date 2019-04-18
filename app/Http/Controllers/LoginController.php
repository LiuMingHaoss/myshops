<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    //登录页面
    public function login(){
        return view('login/login');
    }
    //注册
    public function reg(){
        return view('login/reg');
    }
    //发送邮件
    public function sendemail(Request $request){
        $user_email=request()->input('user_email');
        $code=rand(100000,999999);
        $flag=Mail::send('login.sendemail',['data'=>$code],function($message){
            $to ='17542101627@163.com';
            $message ->to($to)->subject('测试邮件');
        });
        if($flag==''){
            session(['code'=>['code'=>$code]]);
            $arr=[  
                'font'=>'发送邮件成功，请查收!',
                'code'=>1
            ];
            return json_encode($arr);
        }else{
            $arr=[
                'font'=>'发送邮件失败，请重试！',
                'code'=>1
            ];
            return json_encode($arr);
        }
    }
    //登录执行
    public function logindo(Request $request){
        $data=$request->input();
        $where=[
            'user_email'=>$data['user_email'],
        ];
        $res=DB::table('shop_user')->where($where)->first();
        if(!$res){
            echo json_encode(['font'=>'用户名不存在','code'=>2]);
        }else{
            $pwd=decrypt($res->user_pwd);
            if($pwd===$data['user_pwd']){
                session(['user'=>['user_name'=>$res->user_name,'user_id'=>$res->user_id]]);
                echo json_encode(['font'=>'登录成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'密码错误','code'=>2]);
            }
        }

    }
    //退出
    public function quit(){
        request()->session()->flush();
        return redirect('/user/userpage');
    }
    //验证唯一
    public function checkemail(){
        $user_email=request()->input('user_email');
//        echo $user_email;
        $res=DB::table('shop_user')->where('user_email',$user_email)->first();
        if($res){
            $arr=[
                'font'=>'该邮箱已注册',
                'code'=>2
            ];
            return json_encode($arr);
        }else{
            return json_encode(['font'=>'']);
        }
    }
    //注册执行
    public function regdo(){
        $data=request()->input();
        $data['create_time']=time();
        $data['user_pwd']=encrypt($data['user_pwd']);
        $res=DB::table('shop_user')->insert($data);
        if($res){
            $arr=[
                'font'=>'注册成功',
                'code'=>1
            ];
            return json_encode($arr);
        }else{
            $arr=[
                'font'=>'注册失败',
                'code'=>2
            ];
            return json_encode($arr);
        }
    }
}
