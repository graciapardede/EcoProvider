@extends('layouts.app')

@section('title', 'EcoProvider - Berita Lingkungan')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg shadow-lg p-8 mb-8">
    <h1 class="text-4xl font-bold mb-4">🌿 Berita Lingkungan Terkini</h1>
    <p class="text-lg">Informasi terbaru tentang lingkungan, pengelolaan sampah, dan teknologi hijau</p>
</div>

<!-- News Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($news as $item)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <!-- Thumbnail -->
        @if($item->thumbnail_url)
            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                <span class="text-white text-4xl">🌱</span>
            </div>
        @endif

        <!-- Content -->
        <div class="p-6">
            <!-- Category Badge -->
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mb-3">
                {{ $item->category }}
            </span>

            <!-- Title -->
            <h2 class="text-xl font-bold text-gray-800 mb-2 hover:text-green-600">
                <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
            </h2>

            <!-- Summary -->
            <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->summary }}</p>

            <!-- Date & Read More -->
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">{{ $item->published_at->format('d M Y') }}</span>
                <a href="{{ route('news.show', $item->id) }}" class="text-green-600 hover:text-green-800 font-semibold">
                    Baca Selengkapnya →
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12">
        <p class="text-gray-500 text-lg">Belum ada berita tersedia.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($news->hasPages())
<div class="mt-8">
    {{ $news->links() }}
</div>
@endif
@endsection
