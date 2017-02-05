<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

  //登录页
  Route::get('login','View\MemberController@toLogin');
  //注册页
  Route::get('register','View\MemberController@toRegister');
  //分类页
  Route::get('category','View\CategoryController@toCategory');
  //分类下的全部商品页
  Route::get('product/category_id/{category_id}','View\CategoryController@toProduct');
  //产品详情页
  Route::get('product/{product_id}','View\CategoryController@toPdtContent');

  //提供接口的服务路由
  Route::group(['prefix'=>'service','namespace'=>'Service'],function (){
    //获取验证码图片
    Route::get('validateCode','ValidateController@create');
    //发送短信验证码
    Route::post('smsCode','ValidateController@sendSMS');
    //用户注册：接收ajax请求后提供接口返回
    Route::post('register','MemberController@register');
    //点击邮箱链接后返回的路由
    Route::get('validateEmail','MemberController@validateEmail');
    //注册服务
    Route::post('login','MemberController@login');
    //ajax获得对应parent_id的分类信息
    Route::get('category/parent_id/{parent_id}','CategoryController@getCategoryByParentId');
    //****加入购物车写入cookie接口****
    Route::get('cart/add/{parent_id}','CartController@addCart');
  });

});
