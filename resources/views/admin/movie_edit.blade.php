{{-- resources/views/movie_update.blade.php --}}
@extends('layout')

{{-- Override title --}}
@section('title', 'Admin')

@section('content')
    <div class="px-4 sm:px-0">
        <main class=" flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                        Edit Data Movie
                    </h2>
                </div>
                <!-- Update Form -->
                <div class=" sm:px-10 ">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.movie.update', $movie->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Judul
                            </label>
                            <div class="mt-1">
                                <input id="judul" name="judul" type="text" autocomplete="off" required
                                    value="{{ old('judul', $movie->judul) }}"
                                    class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300 @error('judul') border-red-500 @enderror"
                                    placeholder="Masukkan Judul Movie">
                            </div>
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="sinopsis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sinopsis
                            </label>
                            <div class="mt-1">
                                <textarea id="sinopsis" name="sinopsis" type="text" rows="3" autocomplete="off" required
                                    class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300 @error('sinopsis') border-red-500 @enderror"
                                    placeholder="Masukkan Sinopsis Movie">{{ old('sinopsis', $movie->sinopsis) }}</textarea>
                            </div>
                            @error('sinopsis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Rating
                            </label>
                            <div class="mt-1">
                                <input id="rating" name="rating" type="number" step="0.1" autocomplete="off"
                                    required value="{{ old('rating', $movie->rating) }}"
                                    class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300 @error('rating') border-red-500 @enderror"
                                    placeholder="Masukkan Rating Movie">
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tahun_rilis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tahun Rilis
                            </label>
                            <div class="mt-1">
                                <input id="tahun_rilis" name="tahun_rilis" type="number" min="1900"
                                    max="{{ date('Y') }}" autocomplete="off" required
                                    value="{{ old('tahun_rilis', $movie->tahun_rilis) }}"
                                    class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300 @error('tahun_rilis') border-red-500 @enderror"
                                    placeholder="Masukkan Tahun Rilis Movie">
                            </div>
                            @error('tahun_rilis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="poster"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Poster</label>
                            <div class="mt-1">
                                <input id="poster" name="poster" type="file" accept="image/*"
                                    class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300 @error('poster') border-red-500 @enderror">
                            </div>
                            @error('poster')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Poster Saat Ini:</p>
                            @if ($movie->poster)
                                <img src="{{ asset('storage/' . $movie->poster) }}"
                                    class="mt-2 max-h-48 rounded-lg shadow-md" alt="Poster Lama">
                            @else
                                <p class="text-sm text-gray-500">Belum ada poster.</p>
                            @endif
                        </div>
                        <div id="preview-container" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Preview Poster Baru:</p>
                            <img id="poster-preview" src="#" alt="Preview Poster Baru"
                                class="mt-2 max-h-48 rounded-lg shadow-md">
                        </div>
                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                Ubah
                            </button>
                        </div>
                    </form>
        </main>
    </div>
    <script>
        const inputPoster = document.getElementById('poster');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('poster-preview');

        inputPoster.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) {
                previewContainer.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
