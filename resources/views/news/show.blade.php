@extends('layouts.app')

@section('title', $news->title . ' - EcoProvider')

@section('content')
<!-- Breadcrumb -->
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('home') }}" class="text-green-600 hover:text-green-800">← Kembali ke Beranda</a>
    <div class="flex gap-3">
        <a href="{{ route('news.edit', $news->id) }}" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold">
            ✏️ Edit Berita
        </a>
        <form action="{{ route('news.destroy', $news->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">
                🗑️ Hapus
            </button>
        </form>
    </div>
</div>

<!-- Article Container -->
<article class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Thumbnail -->
    @if($news->thumbnail_url)
        <img src="{{ asset('storage/' . $news->thumbnail_url) }}" alt="{{ $news->title }}" class="w-full h-96 object-cover">
    @else
        <div class="w-full h-96 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
            <span class="text-white text-6xl">🌱</span>
        </div>
    @endif

    <!-- Content -->
    <div class="p-8 max-w-4xl mx-auto">
        <!-- Category & Date -->
        <div class="flex items-center justify-between mb-4">
            <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                {{ $news->category }}
            </span>
            <span class="text-gray-500">{{ $news->published_at->format('d F Y, H:i') }} WIB</span>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $news->title }}</h1>

        <!-- Summary -->
        <div class="bg-gray-50 border-l-4 border-green-600 p-4 mb-6">
            <p class="text-lg text-gray-700 italic">{{ $news->summary }}</p>
        </div>

        <!-- Content -->
        <div class="prose prose-lg max-w-none">
            {!! nl2br(e($news->content)) !!}
        </div>

        <!-- Share Section -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Terakhir diupdate: {{ $news->updated_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-semibold">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->id)) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $news->id)) }}&text={{ urlencode($news->title) }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                        Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . route('news.show', $news->id)) }}" target="_blank" class="text-green-600 hover:text-green-800">
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Related News (Optional) -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Lainnya</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $relatedNews = App\Models\News::where('id', '!=', $news->id)
                ->where('category', $news->category)
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        @endphp

        @foreach($relatedNews as $related)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            @if($related->thumbnail_url)
                <img src="{{ asset('storage/' . $related->thumbnail_url) }}" alt="{{ $related->title }}" class="w-full h-32 object-cover">
            @else
                <div class="w-full h-32 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                    <span class="text-white text-2xl">🌱</span>
                </div>
            @endif
            <div class="p-4">
                <h3 class="font-bold text-gray-800 mb-2 hover:text-green-600">
                    <a href="{{ route('news.show', $related->id) }}">{{ Str::limit($related->title, 60) }}</a>
                </h3>
                <span class="text-sm text-gray-500">{{ $related->published_at->format('d M Y') }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
