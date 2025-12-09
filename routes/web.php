<?php

use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Route;

// Homepage - Frontend News with search
Route::get('/', [NewsController::class, 'home'])->name('home');

// Eco News Search - Untuk dipanggil dari project lain
Route::get('/eco-news-search', [NewsController::class, 'ecoNewsSearch'])->name('eco-news-search');

// Eco News API - JSON endpoint untuk integrasi dengan aplikasi lain
Route::get('/eco-news-data', [NewsController::class, 'ecoNewsData'])->name('eco-news-data');

// Alias routes untuk kompatibilitas dengan Green Saving
Route::get('/eco-news/articles', [NewsController::class, 'ecoNewsSearch']);
Route::get('/eco-news/articles/{id}', [NewsController::class, 'show']);

// News Resource Routes (Admin CRUD)
Route::resource('news', NewsController::class);
