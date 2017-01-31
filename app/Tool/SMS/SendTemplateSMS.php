<?php

namespace App\Tool\SMS;

use App\Models\smsResult;

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
        //改写SendTemplateSMS 将所有echo的内容去除，并以接口方式进行返回
      //实例化smsResult接口
       $smsResult = new smsResult();

       // 初始化REST SDK
       $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
       $rest->setAccount($this->accountSid,$this->accountToken);
       $rest->setAppId($this->appId);

       // 发送模板短信
        //echo "Sending TemplateSMS to $to <br/>";
       $result = $rest->sendTemplateSMS($to,$datas,$tempId);
       if($result == NULL ) {
           $smsResult->status = 2;
           $smsResult->message = 'result error!';
         //echo "result error!";
       }
       if($result->statusCode != 0) {
           $smsResult->status = current($result->statusCode); //返回SDK的状态是个对象用current取值
           $smsResult->message = current($result->statusMsg); //返回SDK的信息是个对象用current取值
         //echo "error code :".$result->statusCode."<br>";
         //echo "error msg :".$result->statusMsg."<br>";
       }else{
           $smsResult->status = 0;
           $smsResult->message = '发送成功';
         //echo "Sendind TemplateSMS success!<br/>";
         //获取返回信息
         //$smsmessage = $result->TemplateSMS;
        // echo "dataCreated:".$smsmessage->dateCreated."<br/>";
         //echo "smsMessageSid".$smsmessage->smsMessageSid."<br/>";
       }

       return $smsResult;//注意：此处返回对象即可
  }
}
//使用此方法就可以发送短信，↓↓↓发送手机号，验证码↓↓↓，↓↓有效时间,1表示模板１，这是模板列表
//sendTemplateSMS("18576437523", array(1234, 5), 1);
