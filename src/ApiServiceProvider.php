<?php

namespace Geekpack\Api;

use Illuminate\Support\ServiceProvider;
use Geekpack\Api\Models\ApiRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the middleware
        $this->app['router']->aliasMiddleware('valid.api.route', \Geekpack\Api\Http\Middleware\EnsureApiRouteIsValid::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sanctum.php' => config_path('sanctum.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadSeedersFrom(__DIR__.'/../database/seeders');

        $this->registerDynamicRoutes();
    }

    protected function registerDynamicRoutes()
    {
        // Registrar rutas dinámicamente desde la base de datos
        if (Schema::hasTable('api_routes')) {
            $routes = ApiRoute::all();

            foreach ($routes as $route) {
                Route::{$route->type}($route->route, [$route->controller, $route->class])->name($route->name);
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

