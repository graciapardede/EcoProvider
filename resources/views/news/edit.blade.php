@extends('layouts.app')

@section('title', 'Edit Berita')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('news.index') }}" class="text-green-600 hover:text-green-800 mr-4">← Kembali</a>
        <h1 class="text-3xl font-bold text-gray-800">Edit Berita</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" 
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
                    <option value="Lingkungan" {{ old('category', $news->category) == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="Pengelolaan Sampah" {{ old('category', $news->category) == 'Pengelolaan Sampah' ? 'selected' : '' }}>Pengelolaan Sampah</option>
                    <option value="Energi Terbarukan" {{ old('category', $news->category) == 'Energi Terbarukan' ? 'selected' : '' }}>Energi Terbarukan</option>
                    <option value="Teknologi" {{ old('category', $news->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                    <option value="Penelitian" {{ old('category', $news->category) == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                    <option value="Event" {{ old('category', $news->category) == 'Event' ? 'selected' : '' }}>Event</option>
                    <option value="Gaya Hidup" {{ old('category', $news->category) == 'Gaya Hidup' ? 'selected' : '' }}>Gaya Hidup</option>
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
                          required>{{ old('summary', $news->summary) }}</textarea>
                @error('summary')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Lengkap *</label>
                <textarea name="content" id="content" rows="8" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('content') border-red-500 @enderror" 
                          required>{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Berita</label>
                
                <!-- Current Thumbnail -->
                <div id="currentImage" class="mb-4 {{ $news->thumbnail_url ? '' : 'hidden' }}">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Gambar Saat Ini:</p>
                    <div class="relative inline-block">
                        @if($news->thumbnail_url)
                        <img id="currentThumb" src="{{ asset('storage/' . $news->thumbnail_url) }}" alt="Current Thumbnail" class="w-64 h-40 object-cover rounded-lg border-2 border-gray-300">
                        @else
                        <div class="w-64 h-40 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-sm">Belum ada gambar</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- New Image Preview -->
                <div id="newImagePreview" class="mb-4 hidden">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Preview Gambar Baru:</p>
                    <div class="relative inline-block">
                        <img id="preview" src="" alt="Preview" class="w-64 h-40 object-cover rounded-lg border-2 border-green-500">
                        <button type="button" onclick="removeNewImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                            ×
                        </button>
                    </div>
                </div>

                <!-- File Input -->
                <div class="mt-3">
                    <label for="thumbnail" class="cursor-pointer inline-block">
                        <span class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-block">
                            {{ $news->thumbnail_url ? 'Ganti Gambar' : 'Upload Gambar' }}
                        </span>
                    </label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" 
                           class="hidden"
                           onchange="previewNewImage(event)">
                    <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, GIF | Maksimal: 2MB | Ukuran rekomendasi: 1200x800px</p>
                    <p class="text-sm text-yellow-600 mt-1">Jika upload gambar baru, gambar lama akan otomatis tergantikan</p>
                </div>
                @error('thumbnail')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <script>
            function previewNewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview').src = e.target.result;
                        document.getElementById('newImagePreview').classList.remove('hidden');
                        document.getElementById('currentImage').classList.add('opacity-50');
                    }
                    reader.readAsDataURL(file);
                }
            }

            function removeNewImage() {
                document.getElementById('thumbnail').value = '';
                document.getElementById('newImagePreview').classList.add('hidden');
                document.getElementById('preview').src = '';
                document.getElementById('currentImage').classList.remove('opacity-50');
            }
            </script>

            <!-- Published At -->
            <div class="mb-6">
                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $news->published_at->format('Y-m-d\TH:i')) }}" 
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
                    Update Berita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
