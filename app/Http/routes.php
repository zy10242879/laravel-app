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
  //获取验证码图片
  Route::get('service/validateCode','Service\ValidateController@create');
  //发送短信验证码
  Route::post('service/smsCode','Service\ValidateController@sendSMS');
  //用户注册：接收ajax请求后提供接口返回
  Route::post('service/register','Service\MemberController@register');
  //点击邮箱链接后返回的路由
  Route::get('service/validateEmail','Service\MemberController@validateEmail');
});
