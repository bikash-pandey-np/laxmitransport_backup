<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShipperMustVerifyEmail
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
        if ($request->route()->getName() === 'shipper.logout') {
            Log::info('from logout');
            return $next($request);
        }

        $user = Auth::guard('shipper')->user();

        if (!$user || !$user->is_email_verified) {
            Log::info('from verify');
            return redirect()->route('shipper.auth.verify')
                ->with('error', 'You need to verify your email address.');
        }

        return $next($request);
    }
}
