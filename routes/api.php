<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsApiController;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// News API Routes
Route::get('/news', [NewsApiController::class, 'index']);
Route::get('/news/{id}', [NewsApiController::class, 'show']);
Route::get('/news-search', [NewsApiController::class, 'search']);
