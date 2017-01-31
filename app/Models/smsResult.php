<?php
namespace App\Models;

//-------------接口的写法------------
class smsResult{
  public $status;
  public $message;
  public function toJson()
  {
    return json_encode($this,JSON_UNESCAPED_UNICODE);
  }
}
//---------------------------------