<?php

namespace Geekpack\Api\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Geekpack\Api\Models\ApiRoute;

class EnsureApiRouteIsValid
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si la ruta está en la base de datos
        $route = $request->path();
        $method = $request->method();

        $routeBase = explode('/', $route);
        $routeBase = array_slice($routeBase, 0, 3); // Ajusta esto según la estructura de tus rutas
        $routeBase = implode('/', $routeBase);

        $apiRoute = ApiRoute::where('route', 'LIKE', $routeBase . '%')
                            ->where('type', $method)
                            ->first();
        
        if (!$apiRoute) {
            return response()->json(['message' => 'Invalid API route'], 404);
        }

        return $next($request);
    }
}
