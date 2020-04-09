<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminIsMaster
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
        if(Auth::guard('web-admin')->user()->admin_is_master != true) {
            return redirect()->route('home');
        }
        
        return $next($request);
    }
}
