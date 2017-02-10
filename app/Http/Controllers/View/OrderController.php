<?php

namespace App\Http\Controllers\View;

use App\Http\Entity\CartItem;
use App\Http\Entity\Order;
use App\Http\Entity\OrderItem;
use App\Http\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  //订单页
  public function toOrderCommit($product_ids)
  {
    //将$product_ids的字符串转成数组
    $product_ids_array = $product_ids!=''?explode(',',$product_ids):[];
    //获取用户的member_id
    $member =\Session::get('member','');
    //通过产品信息来查询用物的购物车信息
    $cart_items = CartItem::where('member_id',$member->id)->whereIn('product_id',$product_ids_array)->get();
    //获得产品属性，用于页面展示
    $cart_items_array = [];
    $total_price = 0;
    foreach ($cart_items as $cart_item) {
      $cart_item->product = Product::where('id',$cart_item->product_id)->first();
      if ($cart_item != null){
        $total_price += $cart_item->product->price * $cart_item->count;
        $cart_items_array[] = $cart_item;
      }
    }
    $total_price = number_format($total_price,2);
    return view('order_commit',compact('cart_items_array','total_price'));
  }
  //订单列表
  public function toOrderList()
  {
    //此处所有定义均完成，但地址输入后无法访问,
    //原因为中间件内有个$_SERVER['HTTP_REFERER'],在地址栏直接输入是无法查找到跳转过来的页面的
    //将导航弹出菜单设置我的订单，点击访问即可
    //获取用户信息
    $member = \Session::get('member','');
    //获取用户对应的所有订单信息
    $orders = Order::where('member_id',$member->id)->get();
    //遍历订单信息，获得每一个order_items里面的信息
    foreach($orders as $order){
      $order_items = OrderItem::where('order_id',$order->id)->get();
      $order->order_items = $order_items;//将order_items作为属性放入order的order_items里面
      foreach ($order_items as $order_item){
        //此处应该为快照信息，现在暂时为通过订单的商品id来获得商品信息
        $order_item->product = Product::find($order_item->product_id);
      }
    }
    return view('order_list',compact('orders'));
  }
}
