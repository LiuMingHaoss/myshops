<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CeshiController extends Controller
{
    //
    public function ceshi(){
        return view('ceshi/ceshi');
    }
    public function ceshido(){
        $data=request()->input();
        $where=[
          'user_email'=>$data['user_email']
        ];
        $res=DB::table('shop_user')->where($where)->first();
        $uwhere=[
            'user_id'=>$res->user_id
        ];
        if($res){
            $pwd1=decrypt($res->user_pwd);
            if($data['user_pwd']==$pwd1){
                if($res->error_rum>=3&&(time()-$res->last_error_time)<3600){
                    $mins=60-ceil((time()-$res->last_error_time)/60);
                    echo '账号锁定，请'.$mins.'分钟后再试';
                }else{
                    $info=[
                        'last_error_time'=>null,
                        'error_rum'=>0
                    ];
                    DB::table("shop_user")->where($uwhere)->update($info);
                    echo '登录成功';
                }
            }else{
                if(time()-$res->last_error_time>3600){
                    $info=[
                      'last_error_time'=>time(),
                        'error_rum'=>1
                    ];
                    DB::table("shop_user")->where($uwhere)->update($info);
                    echo '密码错误 还有2次机会';
                }else{
                    if($res->error_rum>=3){
                        $mins=60-ceil((time()-$res->last_error_time)/60);
                        echo '账号锁定，请'.$mins.'分钟后再试';
                    }else{
                        $res->error_rum=$res->error_rum+1;
                        $info=[
                            'last_error_time'=>time(),
                            'error_rum'=>$res->error_rum
                        ];
                        DB::table("shop_user")->where($uwhere)->update($info);
                        $num=3-($res->error_rum);
                        echo '账号或密码有误，您还有'.$num.'次机会';
                    }
                }
            }
        }else{
            echo '账号不存在';
        }
    }
}
