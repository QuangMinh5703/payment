<?php
/*
 * Copyright (c) 2022, Kinal.co, Inc. All Rights Reserved.
 * Internal use only.
 */

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware(['api', 'throttle:api'])
                ->domain($this->app_domain('api'))
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    function app_domain(?string $subDomain = null): string
    {
        if (app()->environment('local')) {
            return parse_url(config('app.url'), PHP_URL_HOST);
        }
        if ($subDomain) {
            $subDomain = "$subDomain.";
        }

        return $subDomain.config('kg-core.domain');
    }
}
