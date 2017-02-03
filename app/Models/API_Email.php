<?php
namespace App\Models;
class API_Email{ //用于传递到邮件发送的参数类
  public $from; //发件人邮箱 单个人为字符串，多个为数组；
  public $to;   //收件人邮箱 单个人为字符串，多个为数组；
  public $cc;   //抄送 单个人为字符串，多个为数组；
  public $attach;  //附件
  public $subject; //主题
  public $content; //内容
}