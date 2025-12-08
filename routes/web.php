<?php

use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Route;

// Homepage - Frontend News
Route::get('/', function () {
    $news = News::orderBy('published_at', 'desc')->paginate(9);
    return view('home', compact('news'));
})->name('home');

// Eco News Search - Untuk dipanggil dari project lain
Route::get('/eco-news-search', [NewsController::class, 'ecoNewsSearch'])->name('eco-news-search');

// Eco News API - JSON endpoint untuk integrasi dengan aplikasi lain
Route::get('/eco-news-data', [NewsController::class, 'ecoNewsData'])->name('eco-news-data');

// News Resource Routes (Admin CRUD)
Route::resource('news', NewsController::class);
