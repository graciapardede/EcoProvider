<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\TipsController;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Status API Route
Route::get('/status', [StatusController::class, 'status']);

// News API Routes
Route::get('/news', [NewsApiController::class, 'index']);
Route::get('/news/{id}', [NewsApiController::class, 'show']);
Route::get('/news-search', [NewsApiController::class, 'search']);

// Events API Routes
Route::get('/events', [EventsController::class, 'index']);
Route::get('/events/{id}', [EventsController::class, 'show']);

// Tips API Routes
Route::get('/tips', [TipsController::class, 'index']);
Route::get('/tips/{id}', [TipsController::class, 'show']);

