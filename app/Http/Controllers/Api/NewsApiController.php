<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsApiController extends Controller
{
    /**
     * Get all news
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug ?? \Illuminate\Support\Str::slug($item->title),
                    'excerpt' => $item->summary,
                    'content' => $item->content,
                    'thumbnail_url' => $item->thumbnail_url ? asset('storage/' . $item->thumbnail_url) : null,
                    'category' => $item->category,
                    'tags' => $item->tags ?? [],
                    'author' => $item->author ?? 'Admin',
                    'source_url' => $item->source_url ?? null,
                    'published_at' => $item->published_at,
                    'created_at' => $item->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get single news by ID
     */
    public function show($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug ?? \Illuminate\Support\Str::slug($news->title),
                'excerpt' => $news->summary,
                'content' => $news->content,
                'thumbnail_url' => $news->thumbnail_url ? asset('storage/' . $news->thumbnail_url) : null,
                'category' => $news->category,
                'tags' => $news->tags ?? [],
                'author' => $news->author ?? 'Admin',
                'source_url' => $news->source_url ?? null,
                'published_at' => $news->published_at,
                'created_at' => $news->created_at,
            ]
        ]);
    }

    /**
     * Search news
     */
    public function search()
    {
        $query = request('q', '');
        
        $news = News::where('title', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->orWhere('summary', 'like', '%' . $query . '%')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug ?? \Illuminate\Support\Str::slug($item->title),
                    'excerpt' => $item->summary,
                    'thumbnail_url' => $item->thumbnail_url ? asset('storage/' . $item->thumbnail_url) : null,
                    'category' => $item->category,
                    'author' => $item->author ?? 'Admin',
                    'published_at' => $item->published_at,
                ];
            });

        return response()->json([
            'success' => true,
            'query' => $query,
            'count' => $news->count(),
            'data' => $news
        ]);
    }
}
