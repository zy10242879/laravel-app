<?php

namespace App\Http\Controllers\Service;

use App\Http\Entity\Member;
use App\Http\Entity\TempPhone;
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
        //---------此段可取消，减少数据库压力（前端发送验证码前已验证，问题不大）-------
        if(Member::where('phone',$data['phone'])->first()){
          $API_Result->status = 4;
          $API_Result->message = '用户已存在！';
          return $API_Result->toJson();
        }
        //-----------------------------------------------------------------
        if($TempPhone = TempPhone::where('phone',$data['phone'])->first()){
          if($TempPhone->code == $data['phone_code']){
            if(time() < strtotime($TempPhone->deadline)){
              $member = new Member();
              $member->phone = $data['phone'];
              $member->password = \Crypt::encrypt($data['password']);
              $member->save();
              //删除临时表中的数据
              $TempPhone->delete();
              $API_Result->status = 0;
              $API_Result->message = '注册成功！';
              return $API_Result->toJson();
            }
          }
        }
        $API_Result->status = 5;
        $API_Result->message = '验证码错误,请重新发送！';
        return $API_Result->toJson();
      }else{ //邮箱注册

      }
    }else{
      //----------此处为单个判断，并设置状态值的用法（可以进行多个同类判断来设置不同的状态值）----------
      $message = $validator->messages()->getMessages();
      if(!empty($message['phone'])){
        $API_Result->status = 2;
        $API_Result->message = current($message['phone']);
        return $API_Result->toJson();
      }
      if(!empty($message['password'])){
        $API_Result->status = 3;
        $API_Result->message = current($message['password']);
        return $API_Result->toJson();
      }
      //-----------以下为对所有错误进行判断，current()仅输出第1个错误（只能设置1个状态值）-----------
      $API_Result->status = 1;
      $API_Result->message = current($validator->messages()->all());
      return $API_Result->toJson();
      //----------使用以上3行可以不使用单个判断，缺点为只有1个状态值----------------------
    }
  }

}
