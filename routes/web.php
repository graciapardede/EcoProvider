<?php

use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Route;

// Homepage - Frontend News
Route::get('/', function () {
    $news = News::orderBy('published_at', 'desc')->paginate(9);
    return view('home', compact('news'));
})->name('home');

// News Resource Routes (Admin CRUD)
Route::resource('news', NewsController::class);
