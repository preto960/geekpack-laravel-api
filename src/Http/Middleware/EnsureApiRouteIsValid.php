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

        $apiRoute = ApiRoute::where('route', $route)
                            ->where('type', strtolower($method))
                            ->first();
        
        if (!$apiRoute) {
            return response()->json(['message' => 'Invalid API route'], 404);
        }

        return $next($request);
    }
}
