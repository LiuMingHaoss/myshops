<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//电商项目
//首页
Route::get('/index/index','IndexController@index');
//我的潮购
Route::get('/user/userpage','UserController@userpage');
//全部商品
Route::get('/goods/allshops','GoodsController@allshops');
Route::get('/goods/goodsdesc/{id}','GoodsController@goodsdesc');
Route::post('/goods/newgoods','GoodsController@newgoods');

//购物车
Route::get('/cart/shopcart','CartController@shopcart');
Route::post('/cart/cartdo','CartController@cartdo');
Route::post('/cart/priceall','CartController@priceall');
Route::post('/cart/changprice','CartController@changprice');
//收货地址
Route::get('/address/address','AddressController@address');
Route::get('/address/addressadd','AddressController@addressadd');
Route::post('/address/area','AddressController@area');
Route::post('/address/addressadddo','AddressController@addressadddo');
Route::post('/address/default','AddressController@default');

//订单
Route::get('/order/orderlist/{id}','OrderController@orderlist');
Route::get('/order/orderpay','OrderController@orderpay');
Route::post('/order/suborder','OrderController@suborder');
Route::get('/order/paygo/{order_no}','OrderController@paygo');
Route::get('/returnpay','OrderController@returnpay');
Route::any('/notifypay','OrderController@notifypay');

//登录
Route::get('/login/login','LoginController@login');
Route::get('/login/reg','LoginController@reg');
Route::get('/login/sendemail','LoginController@sendemail');
Route::post('/login/checkemail','LoginController@checkemail');
Route::post('/login/regdo','LoginController@regdo');
Route::get('/cms/cmslist','CmsController@cmslist');



Route::get('/alipay/{orderon}','CmsController@alipay');





Route::get('/list', 'GoodsController@goodslist');
Route::get('/desc/{goods_id}', 'GoodsController@goodsdesc');
Route::get('/del/{goods_id}', 'GoodsController@goodsdel');
Route::get('/update/{goods_id}', 'GoodsController@goodsupdate');
Route::any('/updatedo', 'GoodsController@updatedo');


//登录执行
Route::post('/login/logindo','LoginController@logindo');
Route::get('/login/quit','LoginController@quit');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//测试
Route::get('/ceshi','CeshiController@ceshi');
Route::any('/ceshi/ceshido','CeshiController@ceshido');