<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }




    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('watch_dog', function (Request $request) {
            $userId = $request->user()?->id;

            // If user ID is not present, apply IP rate limit or return error
            if (!$userId) {
                return Limit::none(); // or use IP-based rate limit
            }

            $cacheKey = 'rate_limit:user:' . $userId;
            $requestLimit = 1;
            $timeWindow = 5; // 5 seconds

            // Check if the cache key exists
            if (Cache::has($cacheKey)) {
                // return response('Too many requests', 429);


            return laraResponse('too_many_request', [
                'msg' => 'Too many requests. Please try again after 5 seconds.',
            ])->error();
            }

            // Store the current timestamp in the cache with a TTL of the time window
            Cache::put($cacheKey, now(), $timeWindow);

            return Limit::none();
        });
    }
}
