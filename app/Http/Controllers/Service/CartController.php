<?php

namespace App\Http\Controllers\Service;

use App\Models\API_Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    //添加购物车方法接口
  public function addCart($product_id)
  {
    $_cart = \Cookie::get('_cart');//获取cookie
    $_cart_array = $_cart != null ? explode(',',$_cart):[];
    $count =1;                          //其它解决办法为定义一个空数组，将内容写入
    foreach ($_cart_array as &$value){  //**引用传递**要想将遍历出来的$value在循环内部改变，要使用&$value
      $index = strpos($value,':');
      if(substr($value,0,$index)==$product_id){
        $count = substr($value,$index+1)+1;
        $value = $product_id .':'.$count; //当使用&$value后phpstorm会显示为白色，不然为灰色
        break;
      }
    }
    if ($count == 1){
      $_cart_array[] = $product_id.':'.$count;//此处为，点击后当没有这个商品时，将商品加入到数组中
    }                //↑↑可用array_push($_cart_array,$product_id.':'.$count);(不推荐，用函数会影响速度)
    //将$_cart_array数组转成字符串，并存入到cookie中
    $_cart = implode(',',$_cart_array);
    $lifetime = 60*24*365;  //设置cookie过期时间为1年  如果不写默认为当关闭浏览器时
    $API_Result = new API_Result();
    $API_Result->status = 0;
    $API_Result->message = '成功加入购物车！';
    return response($API_Result->toJson())->cookie('_cart',$_cart,$lifetime);
    //return response($API_Result->toJson())->withcookie(\Cookie::forever('_cart',$_cart));
            //----------------------cookie用法--------------
            //写入cookie的方法  response(返回的内容)->cookie('名字','内容字符串'[,'时间1为1分钟']);
              //response(返回的内容)->withcookie(\Cookie::forever('名字','内容字符串'));//永久(5年)cookie
  }
  //删除购物车中的商品的接口
  public function deleteCart()
  {
    $API_Result = new API_Result();
    $product_ids = Input::get('product_ids','');
    //先判断一下$product_ids是否为空字符串
    if($product_ids == ''){
      $API_Result->status = 1;
      $API_Result->message = '商品id为空！';
      return $API_Result->toJson();
    }
    //----------判断cookie中的id,是否在要删除的数组id中，如果是就将其删除的逻辑--------
    $product_ids_array = explode(',',$product_ids);//将传过来的字符串通过','分割为数组
    $_cart = \Cookie::get('_cart');//获得cookie的字符串
    $_cart_array = explode(',',$_cart);//将字符串转为数组
    //遍历cookie数组，获得商品id，判断是否在要删除的数组id中
    foreach ($_cart_array as $k=>$value){
      $index = strpos($value,':');
      $product_id = substr($value,0,$index);
      if (in_array($product_id,$product_ids_array)){//判断是否在id中
        unset($_cart_array[$k]);//将数组中对应下标的元素删除
              //删除cookie中的，在购物车点击删除的商品数组
      }
    }
    //将删除后的数组写入cookie中

    $API_Result->status = 0;
    $API_Result->message = '删除成功！';
    return response($API_Result->toJson())->cookie('_cart',implode(',',$_cart_array),60*24*365);
  }
}
