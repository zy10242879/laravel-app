<?php

namespace App\Http\Controllers\View;

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
    return view('pdt_content',compact('product','pdt_content','pdt_images'));
    }
}
