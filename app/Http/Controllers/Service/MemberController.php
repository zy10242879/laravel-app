<?php

namespace App\Http\Controllers\Service;

use App\Models\API_Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MemberController extends Controller
{
  public function register()
  {
    $data = Input::all();
    $API_Result = new API_Result();
    $rules = [
      'phone' => 'required_without:email|regex:/^1[34578][0-9]{9}$/',
      'email' => 'required_without:phone|email',
      'password' => 'required|min:6',
      'confirm' => 'required|min:6|same:password',
      'phone_code' => 'required_without:validate_code|regex:/^[0-9]{6}$/',
      'validate_code' => 'required_without:phone_code|regex:/^[a-zA-Z0-9]{4}$/',

    ];
    $messages = [
      'phone.required_without' => '手机号或邮箱不能为空！',
      'phone.regex' => '请输入正确的手机号！',
      'email.email' => '请输入正确的邮箱！',
      'password.required' => '密码不能为空！',
      'password.min' => '密码不少于6位',
      'confirm.required' => '确认密码不能为空！',
      'confirm.min' => '确认密码不少于6位！',
      'confirm.same' => '两次密码不一致',
      'phone_code.required_without' => '验证码不能为空！',
      'phone_code.regex' => '验证码为6位数字',
      'validate_code.regex' => '验证码为4位',
    ];
    $validator = \Validator::make($data, $rules, $messages);
    if ($validator->passes()) {
      //通过所有验证后，进行完成注册逻辑
      if($data['phone'] != ''){//手机号注册

      }else{ //邮箱注册

      }
    }else{
      $API_Result->status = 1;
      $API_Result->message = current($validator->messages()->all());
      //var_dump(current($validator->messages()->all()));
      return $API_Result->toJson();
    }
  }
}
