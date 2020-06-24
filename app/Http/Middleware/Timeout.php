<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Timeout
{

    public function handle($request, Closure $next)
    {
       $time = date("G");

       if(($time >= 9 && $time < 15 /*false*/) || (session('role_id') >= 1 && session('role_id') <= 3))
       {
        return $next($request);
       }else return redirect('/timeout');

    }
}
