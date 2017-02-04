<?php

namespace App\Http\Controllers\Service;

use App\Http\Entity\Category;
use App\Models\API_Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
  //ajax获取父id下的分类信息
  public function getCategoryByParentId($parent_id)
  {
    $categorys = Category::where('parent_id',$parent_id)->get();
    $API_Result = new API_Result();
    $API_Result->status = 0;
    $API_Result->message = '返回成功！';
    $API_Result->categorys = $categorys;//脚本语言特性，可以随时定义成员变量，效率低下(尽量少用)
    return $API_Result->toJson();
  }
}
