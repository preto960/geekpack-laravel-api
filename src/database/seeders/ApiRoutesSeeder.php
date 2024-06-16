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
            ['type' => 'get', 'route' => 'api/email/verify', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'emailVerificationNotice', 'name' => 'verification.notice', 'middleware' => 'auth:sanctum'],
            ['type' => 'get', 'route' => 'api/email/verify/{id}/{hash}', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'verify', 'name' => 'verification.verify', 'middleware' => 'auth:sanctum,signed'],
            ['type' => 'post', 'route' => 'api/email/resend', 'controller' => 'Geekpack\Api\Http\Controllers\AuthController', 'class' => 'resendVerificationEmail', 'name' => 'verification.send', 'middleware' => 'auth:sanctum'],
            ['type' => 'get', 'route' => 'api/protected-route', 'controller' => 'Geekpack\Api\Http\Controllers\SomeController', 'class' => 'someMethod', 'name' => 'protected.route', 'middleware' => 'auth:sanctum,verified'],
        ];

        foreach ($routes as $route) {
            ApiRoute::create($route);
        }
    }
}
