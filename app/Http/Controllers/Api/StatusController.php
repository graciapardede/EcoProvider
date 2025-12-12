<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Get API status
     */
    public function status()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'version' => '1.0.0',
            'environment' => config('app.env'),
            'api_url' => config('app.url'),
        ]);
    }
}
