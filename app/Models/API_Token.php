<?php
namespace App\Models;
class API_Token{
  static function token($member,$time)
  {
    return MD5(MD5($member).base64_encode($_SERVER['REMOTE_ADDR']).MD5($time));
  }
}