<?php

namespace App\Http\Controllers\Service;

use App\Http\Entity\Member;
use App\Http\Entity\TempPhone;
use App\Models\API_Email;
use App\Models\API_Result;
use App\Models\API_Token;
use App\Tool\SMS\SendTemplateSMS;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use SuperClosure\Analyzer\Token;

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
        //获取session中的验证码，验证码是否同输入的一致
        $validate_code_session = \Session::get('validate_code','');
        if($validate_code_session != strtolower($data['validate_code'])){
          $API_Result->status = 6;
          $API_Result->message = '验证码不正确';
          return $API_Result->toJson();
        }
        if(Member::where('email',$data['email'])->first()){
          $API_Result->status = 7;
          $API_Result->message = '邮箱已存在！';
          return $API_Result->toJson();
        }
        \Session::forget('validate_code');//将session中的验证码删除
        //发送邮件生成注册链接
        //--------生成一个签名，用于验证点击链接后是否通过-------
            //--也可以使用UUID来替换token Tools/UUID 使用方法：$uuid = UUID::create();(如报500使用第3方类引入)
        $time = time();
        $token = API_Token::token($data['email'],$time);
        //-----------------------------------------------
        $API_Email = new API_Email();
        $API_Email->to = $data['email'];    //收件人
        $API_Email->cc = '10242879@163.com';//抄送人
        $API_Email->subject = '妞妈烘焙验证'; //主题
        $API_Email->content = '请于2小时内点击该链接完成验证。<br/><a href="http://laravel.app/service/validateEmail?token='.$token.'">欢迎进入妞妈烘焙！（点击完成邮箱注册）<br/>注意：仅同一设备可完成验证！！！</a>';
        //send(参数一：收件视图，要在view中创建,[供视图使用的数组])
        \Mail::send('email_register', ['API_Email' => $API_Email], function ($e) use ($API_Email) {
          //$e->from('hello@app.com', 'Your Application');//config中已配置，不用写
          $e->to($API_Email->to, '尊敬的用户：')//发送到哪里，收件人($API_Email->to)，昵称('尊敬的用户：')
            ->cc($API_Email->cc)//抄送人，(可选)
            ->subject($API_Email->subject);//主题
        });

        //将临时数据加密后存储在session中(可以用数据库临时表来代替-不推荐，session用redis存储后效率提高很多)
        session(['email'=>base64_encode($data['email']),'pw'=>\Crypt::encrypt($data['password']),'time'=>$time]);//作用为，当客户点击邮箱链接后，进入service/validateEmail路由并获取session值进行验证
        $API_Result->status = 0;
        $API_Result->message = '点击邮箱链接，激活帐户！';
        return $API_Result->toJson();
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
  //用户点击链接后注册的方法
  public function validateEmail()
  {
    $API_Result = new API_Result();
    $token = Input::get('token','');
    $email = base64_decode(session('email'));
    $_token = API_Token::token($email,session('time'));
    if(Member::where('email',$email)->first()){
      $API_Result->status = 2;
      $API_Result->message = '用户已激活！';
      return $API_Result->toJson();
    }
    if($token != $_token){
      $API_Result->status = 1;
      $API_Result->message = '验证异常，请重新发送邮件！';
      return $API_Result->toJson();
    }
    //完成判断后，将用户写入member表中
    $member = new Member();
    $member->email = $email;
    $member->password = session('pw');
    $member->save();
    \Session::forget(['email','pw','time']);//清除session中保存的临时数据
    //可以在session中写入登录数据，跳转到登录页面时判断session，并进行自动用户登录操作
    return  redirect('login');
  }
}
