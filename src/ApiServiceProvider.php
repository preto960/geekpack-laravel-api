<?php

namespace Geekpack\Api;

use Illuminate\Support\ServiceProvider;
use Geekpack\Api\Models\ApiRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']->aliasMiddleware('valid.api.route', \Geekpack\Api\Http\Middleware\EnsureApiRouteIsValid::class);
        $this->app['router']->aliasMiddleware('auth:sanctum', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php',
            'auth'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/sanctum.php',
            'sanctum'
        );
    }

    public function boot()
    {

        $this->publishes([
            __DIR__.'/../config/sanctum.php' => config_path('sanctum.php'),
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/Database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/Helpers/ApiFunctions.php' => app_path('Helpers/ApiFunctions.php'),
        ], 'helpers');  

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

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

                if ($route->function) {
                    Route::middleware($middleware)
                        ->{$route->type}($route->route, function() use ($route) {
                            if (function_exists($route->function)) {
                                return call_user_func($route->function);
                            } else {
                                return response()->json(['error' => 'Function ' . $route->function . ' does not exist'], 404);
                            }
                        })
                        ->name($route->name);
                } else {
                    Route::middleware($middleware)
                        ->{$route->type}($route->route, [$route->controller, $route->class])
                        ->name($route->name);
                }
            }
        }
    }
}

