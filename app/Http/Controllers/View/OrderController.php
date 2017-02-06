<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  public function toOrderPay($product_ids)
  {
    return view('order_pay',compact('product_ids'));
  }
}
