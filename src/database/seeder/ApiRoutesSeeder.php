<?php

use Illuminate\Database\Seeder;
use Geekpack\Api\Models\ApiRoute;

class ApiRoutesSeeder extends Seeder
{
    public function run()
    {
        $routes = [
            ['type' => 'post', 'route' => 'register', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'register', 'name' => 'api.register'],
            ['type' => 'post', 'route' => 'login', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'login', 'name' => 'api.login'],
            ['type' => 'post', 'route' => 'logout', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'logout', 'name' => 'api.logout'],
            ['type' => 'post', 'route' => 'forgot-password', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'forgotPassword', 'name' => 'api.forgot-password'],
        ];

        foreach ($routes as $route) {
            ApiRoute::create($route);
        }
    }
}
