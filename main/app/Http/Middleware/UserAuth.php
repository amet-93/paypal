<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Session;
class UserAuth
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
       if (Session::get('user')) {
           return $next($request);
       }
       return redirect('user/login');
   }
}
