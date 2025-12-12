<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiAccessLogger
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Get client IP
        $clientIp = $request->ip();
        $url = $request->fullUrl();
        $method = $request->method();
        $timestamp = now()->toDateTimeString();
        
        // Start measuring response time
        $startTime = microtime(true);

        // Process the request
        $response = $next($request);

        // Calculate response time in milliseconds
        $responseTime = (microtime(true) - $startTime) * 1000;

        // Log the request details
        $logMessage = sprintf(
            "[API ACCESS] IP: %s | Method: %s | URL: %s | Status: %s | Response Time: %.2f ms | Time: %s",
            $clientIp,
            $method,
            $url,
            $response->getStatusCode(),
            $responseTime,
            $timestamp
        );

        Log::channel('api')->info($logMessage);

        // Also log to a dedicated file with more details
        Log::channel('api')->debug(json_encode([
            'client_ip' => $clientIp,
            'method' => $method,
            'url' => $url,
            'status_code' => $response->getStatusCode(),
            'response_time_ms' => round($responseTime, 2),
            'request_headers' => $request->headers->all(),
            'timestamp' => $timestamp,
        ]));

        return $response;
    }
}
