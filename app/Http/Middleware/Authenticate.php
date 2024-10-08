<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Request::is('super-admin*')){
                Session::put('super_admin_auth_url',request()->url());
                return route('super_admin.login_form');
            }
            if (Request::is('admin*')){
                Session::put('admin_auth_url',request()->url());
                return route('admin.login_form');
            }
            return route('driver.login_form');
        }
    }
}
