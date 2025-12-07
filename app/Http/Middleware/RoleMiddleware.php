<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (!$user->role || strtolower($user->role->name) !== strtolower($role)) {
            return response()->json(['message' => 'Forbidden - requires role ' . $role], 403);
        }

        return $next($request);
    }
}
