@extends('layouts.app')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('news.index') }}" class="text-green-600 hover:text-green-800 mr-4">← Kembali</a>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Berita Baru</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('title') border-red-500 @enderror" 
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select name="category" id="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('category') border-red-500 @enderror" 
                        required>
                    <option value="">Pilih Kategori</option>
                    <option value="Lingkungan" {{ old('category') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="Pengelolaan Sampah" {{ old('category') == 'Pengelolaan Sampah' ? 'selected' : '' }}>Pengelolaan Sampah</option>
                    <option value="Energi Terbarukan" {{ old('category') == 'Energi Terbarukan' ? 'selected' : '' }}>Energi Terbarukan</option>
                    <option value="Teknologi" {{ old('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Penelitian" {{ old('category') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                    <option value="Event" {{ old('category') == 'Event' ? 'selected' : '' }}>Event</option>
                    <option value="Gaya Hidup" {{ old('category') == 'Gaya Hidup' ? 'selected' : '' }}>Gaya Hidup</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div class="mb-6">
                <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan *</label>
                <textarea name="summary" id="summary" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('summary') border-red-500 @enderror" 
                          required>{{ old('summary') }}</textarea>
                @error('summary')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Lengkap *</label>
                <textarea name="content" id="content" rows="8" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('content') border-red-500 @enderror" 
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail -->
            <div class="mb-6">
                <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Thumbnail (Opsional)</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('thumbnail') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max 2MB)</p>
                @error('thumbnail')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Published At -->
            <div class="mb-6">
                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('published_at') border-red-500 @enderror">
                @error('published_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('news.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
