<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('news', 'public');
        }

        News::create([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'thumbnail_url' => $thumbnailPath,
            'published_at' => $validated['published_at'] ?? now(),
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified news.
     */
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news.
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified news in storage.
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($news->thumbnail_url) {
                Storage::disk('public')->delete($news->thumbnail_url);
            }
            $validated['thumbnail_url'] = $request->file('thumbnail')->store('news', 'public');
        }

        $news->update([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'thumbnail_url' => $validated['thumbnail_url'] ?? $news->thumbnail_url,
            'published_at' => $validated['published_at'] ?? $news->published_at,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diupdate!');
    }

    /**
     * Remove the specified news from storage.
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        
        // Delete thumbnail
        if ($news->thumbnail_url) {
            Storage::disk('public')->delete($news->thumbnail_url);
        }
        
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
