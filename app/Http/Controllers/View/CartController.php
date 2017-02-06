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
}
