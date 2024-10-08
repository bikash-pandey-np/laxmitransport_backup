<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DriverExtraSignup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('driver')->user()->extra_signup == 0){
            return redirect()->route('driver.extra_signup.index');
        }
        return $next($request);
    }
}
