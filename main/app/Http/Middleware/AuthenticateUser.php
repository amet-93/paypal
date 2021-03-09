<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Session;
class AuthenticateUser
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
           return redirect('user/dashboard');
       }
       return $next($request);
   }
}
