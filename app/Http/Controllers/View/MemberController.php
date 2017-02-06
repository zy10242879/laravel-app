<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MemberController extends Controller
{
  public function toLogin()
  {
    return view('login');
  }

  public function toRegister()
  {
    return view('register');
  }
}
