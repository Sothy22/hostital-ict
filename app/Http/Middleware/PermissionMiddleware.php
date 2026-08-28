<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->user()->check()) {
            return response()->json(['message' => 'Unauthorized']
            , 401);
        }

        if (!auth()->user()->hasPermission($permission)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
