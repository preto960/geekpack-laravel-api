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
        // Register the middleware
        $this->app['router']->aliasMiddleware('valid.api.route', \Geekpack\Api\Http\Middleware\EnsureApiRouteIsValid::class);
        $this->app['router']->aliasMiddleware('auth:sanctum', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sanctum.php' => config_path('sanctum.php'),
            __DIR__.'/../config/mail.php' => config_path('mail.php'),
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $this->publishes([
            __DIR__.'/../../vendor/laravel/sanctum/Database/migrations/' => database_path('migrations'),
        ], 'sanctum-migrations');

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
}

