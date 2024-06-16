<?php

namespace Geekpack\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Geekpack\Api\Models\ApiRoute;

class ApiRoutesSeeder extends Seeder
{
    public function run()
    {
        $routes = [
            ['type' => 'post', 'route' => 'api/register', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'register', 'name' => 'api.register'],
            ['type' => 'post', 'route' => 'api/login', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'login', 'name' => 'api.login'],
            ['type' => 'post', 'route' => 'api/logout', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'logout', 'name' => 'api.logout', 'middleware' => 'auth:sanctum'],
            ['type' => 'post', 'route' => 'api/forgot-password', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'forgotPassword', 'name' => 'api.forgot-password'],
            ['type' => 'post', 'route' => 'api/reset-password', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'resetPassword', 'name' => 'api.password.update'],
        ];

        foreach ($routes as $route) {
            ApiRoute::create($route);
        }
    }
}
