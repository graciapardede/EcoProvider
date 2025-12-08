@extends('layouts.app')

@section('title', 'Eco News - Berita Lingkungan')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg shadow-lg p-8 mb-8">
    <h1 class="text-4xl font-bold mb-4">🌿 Berita Lingkungan Terkini</h1>
    <p class="text-lg">Baca informasi seputar lingkungan hidup dan keberlanjutan</p>
</div>

<!-- Search & Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <form action="{{ route('eco-news-search') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search Input -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">🔍 Cari Berita</label>
                <input 
                    type="text" 
                    name="search" 
                    id="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari judul, ringkasan, atau konten berita..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">📂 Kategori</label>
                <select 
                    name="category" 
                    id="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <button 
                type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold"
            >
                Cari Berita
            </button>
            <a 
                href="{{ route('eco-news-search') }}"
                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold"
            >
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Results Summary -->
@if(request('search') || request('category'))
<div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
    <p class="text-blue-800">
        <strong>{{ $news->total() }}</strong> berita ditemukan
        @if(request('search'))
            untuk pencarian "<strong>{{ request('search') }}</strong>"
        @endif
        @if(request('category'))
            dalam kategori "<strong>{{ request('category') }}</strong>"
        @endif
    </p>
</div>
@endif

<!-- News Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($news as $item)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <!-- Thumbnail -->
        @if($item->thumbnail_url)
            <img src="{{ asset('storage/' . $item->thumbnail_url) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
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
                <span class="text-sm text-gray-500">
                    📅 {{ $item->published_at->format('d M Y') }}
                </span>
                <a href="{{ route('news.show', $item->id) }}" class="text-green-600 hover:text-green-800 font-semibold">
                    Baca →
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12">
        <div class="text-6xl mb-4">🔍</div>
        <p class="text-gray-500 text-lg mb-2">Tidak ada berita ditemukan</p>
        <p class="text-gray-400">Coba ubah kata kunci atau filter pencarian Anda</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($news->hasPages())
<div class="mt-8">
    {{ $news->appends(request()->query())->links() }}
</div>
@endif

<!-- Info Banner -->
@if($news->isEmpty() && !request('search') && !request('category'))
<div class="mt-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
    <div class="flex items-start">
        <div class="text-3xl mr-4">⚠️</div>
        <div>
            <h3 class="font-bold text-yellow-800 mb-2">Perhatian!</h3>
            <p class="text-yellow-700">
                Layanan EcoProvider sedang tidak tersedia. Silakan coba lagi nanti.
            </p>
        </div>
    </div>
</div>
@endif
@endsection
