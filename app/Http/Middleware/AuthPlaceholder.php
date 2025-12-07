<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthPlaceholder
{
    public function handle(Request $request, Closure $next)
    {
        // Very small placeholder: if Authorization header present, set a fake user via auth()->loginUsingId
        $header = $request->header('Authorization');
        if ($header && preg_match('/Bearer\s+(.*)/', $header, $m)) {
            $token = $m[1];
            // For scaffold: token format is base64("token-for-{id}-...")
            try {
                $decoded = base64_decode($token);
                if (preg_match('/token-for-(\d+)-/', $decoded, $mm)) {
                    $userId = intval($mm[1]);
                    auth()->loginUsingId($userId);
                }
            } catch (\Exception $e) {
                // ignore
            }
        }

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}
