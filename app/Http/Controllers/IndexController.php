<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller
{
    //
    public function index(){
        $goodsInfo=DB::table('shop_goods')->where('is_up',1)->paginate(10);
        return view('index/index',['goodsInfo'=>$goodsInfo]);
    }
    
}
