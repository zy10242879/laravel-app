<?php

namespace App\Http\Controllers\Service;

use App\Tool\ValidateCode\ValidateCode;
use App\Http\Controllers\Controller;

class ValidateCodeController extends Controller
{
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
}
