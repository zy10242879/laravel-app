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
  Route::any('validateCode','Service\ValidateCodeController@create');


});
