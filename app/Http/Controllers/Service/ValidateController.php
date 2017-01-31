<?php

namespace App\Http\Controllers\Service;

use App\Http\Entity\TempPhone;
use App\Models\API_Result;
use App\Tool\SMS\SendTemplateSMS;
use App\Tool\ValidateCode\ValidateCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ValidateController extends Controller
{
  //创建验证码图片
  public function create()
  {
    //使用第三方类的命名空间的方法
    //①在Tool目录下加入第三方文件目录及类（Tool可随意起名及放置位置）
    //②在composer.json中修改以下
    /*
    "autoload": {
    "classmap": [
      "database",
    ---------加入命名空目录所在的目录位置及名字，注意：名字需要和类名一致------------
      "app/Tool/ValidateCode/ValidateCode.php"
    ---------------------------------------------------------------------
    ],
    */
    //③项目目录下运行composer dump-autoload
    $validateCode = new ValidateCode;
    return $validateCode->doimg();
  }
  //⑴在Tools中加入SMS两个云通迅发送类
  //⑵对SendTemplateSMS.php进行配置
  //⑶创建：手机验证码发送方法
  public function sendSMS()
  {
    $API_Result = new API_Result();
    //⑹此处为业务逻辑，因项目而定，此处为获取手机号，判断手机号，
    $input['phone'] = Input::get('phone','');
    if($input['phone'] == ''){
      //-----以接口的调用方法进行返回-----⑺在App中新建Models文件夹作为存放接口用
      //⑻注意查看：App/Models/API_Result.php接口文件
      $API_Result->status = 1;
      $API_Result->message = '手机号不能为空！';
      return $API_Result->toJson();
    }
    //⑷注意：SendTemplateSMS此类中的账号配置
    $SendTemplateSMS = new SendTemplateSMS;
    //-------生成6位随机码-------可以参考验证码类获取随机因子，但如果有英文用户体验会下降（一般用6位数字）
    $code = '';
    $charset = '1234567890';//此处可加入英文，$code中就会产生6位英文+数字
    $_len = strlen($charset)-1;//获取字符串长度10 -1 长度为9
    for($i=0;$i<6;++$i){
      $code .= $charset[mt_rand(0,$_len)];//$charset[]这种写法返回下标的字符串例：$charset[0]返回1
    }
    //⑸调用以下方法进行发送
    //$SendTemplateSMS->sendTemplateSMS('测试手机号', array($code, 30), 1);
    //-------------------------------------------------------------------------
    //⑼发送短信，并存储到临时表temp_phone中，返回接口信息
    $API_Result = $SendTemplateSMS->sendTemplateSMS($input['phone'], array($code, 30), 1);
    if($API_Result->status == 0){
      $input['code'] = $code;//此处注意：存入数据库字段类型用char，避免用int后首字0不存储的问题
      $input['deadline'] = date('Y-m-d H:i:s',time()+60*30);
      if(!TempPhone::where('phone',$input['phone'])->update($input)){
        TempPhone::create($input);
      }
      $API_Result->status = 0;
      $API_Result->message = '发送成功！';
    }
    return $API_Result->toJson();
    //⑽修改SendTemplateSMS.php中echo输出的结果内容
  }
}