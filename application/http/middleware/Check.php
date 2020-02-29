<?php

namespace app\http\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
//        if (session('?admin.username')){
            return $next($request);
//        }else{
//            return redirect('admin/index/login');
//        }


    }
}
