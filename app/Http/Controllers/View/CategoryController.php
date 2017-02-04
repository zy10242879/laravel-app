<?php

namespace App\Http\Controllers\View;

use App\Http\Entity\Category;
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
}
