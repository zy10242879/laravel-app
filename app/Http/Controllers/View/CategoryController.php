<?php

namespace App\Http\Controllers\View;

use App\Http\Entity\CartItem;
use App\Http\Entity\Category;
use App\Http\Entity\PdtContent;
use App\Http\Entity\PdtImages;
use App\Http\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
  public function toCategory()
  {
              //查找出parent_id是null的记录，是顶级分类的数据
    $categorys = Category::whereNull('parent_id')->get();
    return view('category',compact('categorys'));
    }

  public function toProduct($category_id)
  {
    $products = Product::where('category_id',$category_id)->get();
    return view('product',compact('products'));
    }

  public function toPdtContent($product_id)
  {
    $product = Product::find($product_id);
    $pdt_content = PdtContent::where('product_id',$product_id)->first();
    $pdt_images = PdtImages::where('product_id',$product_id)->get();
    $count =0;
    //已登录
    $member = \Session::get('member','');
    if ($member != ''){
      $cart_items = CartItem::where('member_id', $member->id)->get();
      foreach ($cart_items as $cart_item) {
        if ($cart_item->product_id == $product_id) {
          $count = $cart_item->count;
          break;
        }
      }
    }else{
          //获得cookie中product_id的num数量，传递到模板中
          $_cart = \Cookie::get('_cart');
          $_cart_array = $_cart != null ? explode(',',$_cart):[];
          foreach ($_cart_array as $value){
            $index = strpos($value,':');
            if(substr($value,0,$index)==$product_id){
              $count = substr($value,$index+1);
              break;
            }
          }
        }
    return view('pdt_content',compact('product','pdt_content','pdt_images','count'));
    }
}
