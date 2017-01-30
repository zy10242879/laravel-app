<?php

namespace App\Tool\SMS;

//use App\Models\M3Result;

class SendTemplateSMS
{
  //主帐号
  private $accountSid='8a216da859b4ceed0159ee4f58bf087f';

  //主帐号Token
  private $accountToken='fce51ae0cced482dbfa37c3aef4eb08d';

  //应用Id
  private $appId='8a216da859b4ceed0159ee4f593e0883';

  //请求地址，格式如下，不需要写https://
  private $serverIP='app.cloopen.com';

  //请求端口
  private $serverPort='8883';

  //REST版本号
  private $softVersion='2013-12-26';

  /**
    * 发送模板短信
    * @param to 手机号码集合,用英文逗号分开
    * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
    * @param $tempId 模板Id
    */
  public function sendTemplateSMS($to,$datas,$tempId)
  {
       //$m3_result = new M3Result;

       // 初始化REST SDK
       $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
       $rest->setAccount($this->accountSid,$this->accountToken);
       $rest->setAppId($this->appId);

       // 发送模板短信
        echo "Sending TemplateSMS to $to <br/>";
       $result = $rest->sendTemplateSMS($to,$datas,$tempId);
       if($result == NULL ) {
//           $m3_result->status = 3;
//           $m3_result->message = 'result error!';
         echo "result error!";
       }
       if($result->statusCode != 0) {
//           $m3_result->status = $result->statusCode;
//           $m3_result->message = $result->statusMsg;
         echo "error code :".$result->statusCode."<br>";
         echo "error msg :".$result->statusMsg."<br>";
       }else{
//           $m3_result->status = 0;
//           $m3_result->message = '发送成功';
         echo "Sendind TemplateSMS success!<br/>";
         //获取返回信息
         $smsmessage = $result->TemplateSMS;
         echo "dataCreated:".$smsmessage->dateCreated."<br/>";
         echo "smsMessageSid".$smsmessage->smsMessageSid."<br/>";
         //TODO 添加成功处理逻辑
       }

       //return $m3_result;
  }
}
//使用此方法就可以发送短信，↓↓↓发送手机号，验证码↓↓↓，↓↓有效时间,1表示模板１，这是模板列表
//sendTemplateSMS("18576437523", array(1234, 5), 1);
