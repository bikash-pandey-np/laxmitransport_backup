<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    public $namespace = "App\\Http\\Controllers\\";

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    { 
        $this->configureRateLimiting();

        $this->routes(function () {

            Route::middleware('web')
                ->namespace($this->namespace.'Frontend')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('super-admin')
                ->as('super_admin.')
                ->namespace($this->namespace.'SuperAdmin')
                ->group(base_path('routes/super-admin.php'));

            Route::prefix('driver')
                ->as('driver.')
                ->namespace($this->namespace.'Driver')
                ->group(base_path('routes/driver.php'));

            Route::prefix('carrier')
                ->as('carrier.')
                ->namespace($this->namespace.'Carrier')
                ->group(base_path('routes/carrier.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->as('admin.')
                ->namespace($this->namespace.'Admin')
                ->group(base_path('routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
