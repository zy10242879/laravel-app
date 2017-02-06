<?php

namespace App\Http\Controllers\View;

use App\Http\Entity\CartItem;
use App\Http\Entity\Product;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
  public function toCart()
  {
    $_cart = \Cookie::get('_cart');
    $_cart_array = $_cart != null ? explode(',',$_cart):[];
    //判断用户是否登录
    $member = \Session::get('member','');
    if ($member != ''){
      //如果是登录的，就查找cookie中的数据，并同步到登录用户的购物车表中
      //如果，购物车表中没有cookie中的商品，就将商品加入到表中
      //如果，购物车表中有cookie的商品，就比对，将商品购买数量较多的一个更新到表中
      //定义一个方法，调用，以免toCart()方法中东西太多 syncCart()同步购物车方法
      $cart_items = $this->syncCart($member->id,$_cart_array);
      //cookie的正确用法
      return response()->view('cart',compact('cart_items'))->withCookie(\Cookie::forget('_cart'));
    }
    $cart_items = [];
    foreach ($_cart_array as $k => $value){
      $index = strpos($value,':');
      $cart_item = new CartItem();
      $cart_item->id = $k;
      $cart_item->product_id = substr($value,0,$index);
      $cart_item->count = substr($value,$index+1);
      $cart_item->product = Product::find($cart_item->product_id);
      if ($cart_item->product != null){
        $cart_items[] = $cart_item;
      }
    }
    return view('cart',compact('cart_items'));
  }
  //同步购物车方法
  private function syncCart($member_id,$_cart_array){
    $cart_items = CartItem::where('member_id', $member_id)->get();

    $cart_items_arr = array();
    foreach ($_cart_array as $value) {
      $index = strpos($value, ':');
      $product_id = substr($value, 0, $index);
      $count = (int) substr($value, $index+1);

      // 判断离线购物车中product_id 是否存在 数据库中
      $exist = false;//开关作用
      foreach ($cart_items as $temp) {
        if($temp->product_id == $product_id) {
          if($temp->count < $count) {
            $temp->count = $count;
            $temp->save();
          }
          $exist = true;
          break;
        }
      }

      // 不存在则存储进来
      if($exist == false) {
        $cart_item = new CartItem;
        $cart_item->member_id = $member_id;
        $cart_item->product_id = $product_id;
        $cart_item->count = $count;
        $cart_item->save();
        $cart_item->product = Product::find($cart_item->product_id);
        array_push($cart_items_arr, $cart_item);
      }
    }

    // 为每个对象附加产品对象便于显示
    foreach ($cart_items as $cart_item) {
      $cart_item->product = Product::find($cart_item->product_id);
      array_push($cart_items_arr, $cart_item);
    }

    return $cart_items_arr;
  }
}
