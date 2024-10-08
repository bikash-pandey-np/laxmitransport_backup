<?php

namespace App\Http\Middleware;

use App\Traits\JsonMessages;
use Closure;
use Illuminate\Http\Request;

class AuthApiMiddleware
{
    use JsonMessages;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$type)
    {

        if (auth($type)->check()){
            return $next($request);
        }

        return $this->returnError("unauthidation",401);
    }
}
