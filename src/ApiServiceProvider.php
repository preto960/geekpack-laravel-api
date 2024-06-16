<?php

namespace Geekpack\Api;

use Illuminate\Support\ServiceProvider;
use Geekpack\Api\Models\ApiRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']->aliasMiddleware('valid.api.route', \Geekpack\Api\Http\Middleware\EnsureApiRouteIsValid::class);
        $this->app['router']->aliasMiddleware('auth:sanctum', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);
        $this->app['router']->aliasMiddleware('verified', \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);
        $this->app['router']->aliasMiddleware('signed', \Illuminate\Routing\Middleware\ValidateSignature::class);

        $this->registerEvents();
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sanctum.php' => config_path('sanctum.php'),
            __DIR__.'/../config/mail.php' => config_path('mail.php'),
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
            __DIR__.'/../Events/Registered.php' => app_path('Events/Registered.php'),
            __DIR__.'/../Listeners/SendEmailVerificationNotification.php' => app_path('Listeners/SendEmailVerificationNotification.php'),
        ], 'geekpack-api');

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadSeedersFrom(__DIR__.'/Database/Seeders');

        $this->registerDynamicRoutes();
    }

    protected function registerDynamicRoutes()
    {
        // Verifica si la tabla existe
        if (Schema::hasTable('api_routes')) {
            $routes = ApiRoute::all();

            foreach ($routes as $route) {
                $additionalMiddlewares = $route->middleware ? explode(',', $route->middleware) : [];
                $middleware = array_merge(['api', 'valid.api.route'], $additionalMiddlewares);

                Route::middleware($middleware) // Aplica los middlewares
                    ->{$route->type}($route->route, [$route->controller, $route->class])
                    ->name($route->name);
            }
        }
    }


    protected function loadSeedersFrom($path)
    {
        foreach (glob($path . '/*.php') as $filename) {
            require_once($filename);
        }
    }

    protected function registerEvents()
    {
        $this->app['events']->listen(
            \Geekpack\Api\Events\Registered::class,
            \Geekpack\Api\Listeners\SendEmailVerificationNotification::class
        );
    }
}

