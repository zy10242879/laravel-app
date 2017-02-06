<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $http_referer = $_SERVER['HTTP_REFERER'];//获取上一次访问的地址
      if(!\Session::has('member')){         //必需编码，不然访问地址会出现问题
        //将回调地址存入session中为最合理，存入session就不用使用urlencode()函数了
        \Session::set('http_referer',$http_referer);//urlencode()将url地址编码
        return redirect('login');
      }
        return $next($request);
    }
}
