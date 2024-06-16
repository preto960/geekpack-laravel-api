<?php

namespace Geekpack\Api\Http\Middleware;

use Closure;
use Geekpack\Api\Models\ApiRoute;

class EnsureApiRouteIsValid
{
    public function handle($request, Closure $next)
    {
        $route = $request->path();

        if (!ApiRoute::where('route', $route)->exists()) {
            return response()->json(['message' => 'Invalid API route'], 404);
        }

        return $next($request);
    }
}
