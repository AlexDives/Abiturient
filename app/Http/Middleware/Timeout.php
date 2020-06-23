<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Timeout
{

    public function handle($request, Closure $next)
    {
       $time = date("G");

       if(($time >= 9 && $time < 15) || session('role_id') != 5)
       {
        return $next($request);
       }else return redirect('/timeout');

    }
}
