<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index()
    {
        return News::orderBy('published_at', 'desc')->paginate(10);
    }

    /**
     * Display the specified news.
     */
    public function show($id)
    {
        return News::findOrFail($id);
    }

    /**
     * Search news by keyword.
     */
    public function search(Request $request)
    {
        $q = $request->query('q');
        
        return News::where('title', 'like', "%$q%")
                   ->orWhere('summary', 'like', "%$q%")
                   ->orWhere('category', 'like', "%$q%")
                   ->orderBy('published_at', 'desc')
                   ->get();
    }
}
