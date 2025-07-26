{{-- resources/views/home.blade.php --}}
@extends('layout')

{{-- Override title --}}
@section('title', 'Home')

@section('content')
    <div class="px-4 py-6 sm:px-0">
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition-colors duration-300">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                @auth
                                    <span class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                        Selamat Datang, {{ Auth::user()->username }}
                                    </span>
                                @else
                                    <span class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                        Selamat Datang di Web Pembelian Tiket
                                    </span>
                                @endauth
                            </h1>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                                Pesan tiket kapan saja dan di mana saja secara online dengan mudah.
                            </p>
                        </div>

                        <!-- Movie Carousel Section -->
                        <div class="mt-12">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                                Featured Movies
                            </h2>

                            @if ($movies->count() > 0)
                                <div class="relative max-w-6xl mx-auto">
                                    <!-- Carousel Container -->
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="movieCarousel" class="flex transition-transform duration-500 ease-in-out">
                                            @php
                                                $chunks = $movies->chunk(4);
                                                $mobileChunks = $movies->chunk(2);
                                            @endphp

                                            {{-- Desktop slides (4 movies per slide) --}}
                                            @foreach ($chunks as $index => $chunk)
                                                <div class="w-full flex-shrink-0 px-2 hidden md:block"
                                                    data-slide="desktop-{{ $index }}">
                                                    <div class="grid grid-cols-4 gap-4">
                                                        @foreach ($chunk as $movie)
                                                            <a href="{{ route('movie_detail', $movie->id) }}"
                                                                class="block bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                                                <img src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('default-movie-poster.jpg') }}"
                                                                    alt="{{ $movie->judul }}"
                                                                    class="w-full h-80 object-cover">
                                                                <div class="p-3">
                                                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate"
                                                                        title="{{ $movie->judul }}">
                                                                        {{ $movie->judul }}
                                                                    </h3>
                                                                    <p
                                                                        class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                                        {{ $movie->tahun_rilis }}
                                                                    </p>
                                                                    @if ($movie->rating)
                                                                        <p class="text-xs text-yellow-500 mt-1">
                                                                            ⭐ {{ $movie->rating }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        @endforeach

                                                        {{-- Isi slot kosong jika kurang dari 4 movie --}}
                                                        @for ($i = $chunk->count(); $i < 4; $i++)
                                                            <div
                                                                class="bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg opacity-50">
                                                                <div
                                                                    class="w-full h-80 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                                    <span class="text-gray-500 dark:text-gray-400">No
                                                                        Movie</span>
                                                                </div>
                                                                <div class="p-3">
                                                                    <h3
                                                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                                        -</h3>
                                                                    <p
                                                                        class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                                        -</p>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{-- Mobile slides (2 movies per slide) --}}
                                            @foreach ($mobileChunks as $index => $chunk)
                                                <div class="w-full flex-shrink-0 px-2 md:hidden"
                                                    data-slide="mobile-{{ $index }}">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        @foreach ($chunk as $movie)
                                                            <a href="{{ route('movie_detail', $movie->id) }}"
                                                                class="block bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                                                <img src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('default-movie-poster.jpg') }}"
                                                                    alt="{{ $movie->judul }}"
                                                                    class="w-full h-64 object-cover">
                                                                <div class="p-3">
                                                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate"
                                                                        title="{{ $movie->judul }}">
                                                                        {{ $movie->judul }}
                                                                    </h3>
                                                                    <p
                                                                        class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                                        {{ $movie->tahun_rilis }}
                                                                    </p>
                                                                    @if ($movie->rating)
                                                                        <p class="text-xs text-yellow-500 mt-1">
                                                                            ⭐ {{ $movie->rating }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        @endforeach

                                                        {{-- Isi slot kosong jika hanya 1 movie --}}
                                                        @if ($chunk->count() == 1)
                                                            <div
                                                                class="bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg opacity-50">
                                                                <div
                                                                    class="w-full h-64 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                                    <span class="text-gray-500 dark:text-gray-400">No
                                                                        Movie</span>
                                                                </div>
                                                                <div class="p-3">
                                                                    <h3
                                                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                                        -</h3>
                                                                    <p
                                                                        class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                                        -</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Panah Navigasi -->
                                    <div class="flex justify-between items-center mt-6 px-4">
                                        <button id="prevBtn"
                                            class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 flex items-center justify-center group">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-white transition-colors duration-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>

                                        <div class="text-center">
                                            <span id="currentSlide"
                                                class="text-sm font-medium text-gray-600 dark:text-gray-400">1</span>
                                            <span class="text-sm text-gray-400 dark:text-gray-500"> / </span>
                                            <span id="totalSlides"
                                                class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ ceil($movies->count() / 4) }}</span>
                                        </div>

                                        <button id="nextBtn"
                                            class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 flex items-center justify-center group">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-white transition-colors duration-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Slide Indicators -->
                                    <div class="flex justify-center mt-4 space-x-2">
                                        @for ($i = 0; $i < ceil($movies->count() / 4); $i++)
                                            <button
                                                class="slide-indicator w-3 h-3 rounded-full transition-colors duration-300 {{ $i == 0 ? 'bg-gray-800 dark:bg-white' : 'bg-gray-300 dark:bg-gray-600' }}"
                                                data-slide="{{ $i }}"></button>
                                        @endfor
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="text-gray-500 dark:text-gray-400 mb-4">
                                        <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h4zM6 6v14h12V6H6zm3-2V2h6v2H9z" />
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak Ada Movie Yang
                                        Tersedia
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-400">Tidak ada movie yang dapat ditampilkan di
                                        carousel.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Statistik Cepat Section -->
                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                                Platform Statistik
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg p-6 text-white shadow-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-blue-100 text-sm font-medium">Total Movies</p>
                                            <p class="text-3xl font-bold">{{ $movies->count() }}</p>
                                        </div>
                                        <div class="bg-blue-400 dark:bg-blue-500 rounded-full p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 h-6"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504 1.125 1.125 1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-green-500 to-green-600 dark:from-green-600 dark:to-green-700 rounded-lg p-6 text-white shadow-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-green-100 text-sm font-medium">User Aktif</p>
                                            <p class="text-3xl font-bold">{{ \App\Models\User::count() }}</p>
                                        </div>
                                        <div class="bg-green-400 dark:bg-green-500 rounded-full p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="mt-16">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-0">
                                    Our Movies
                                </h2>
                                <a href="{{ route('movie') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors duration-300">
                                    View All Movies
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            @if ($movies->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                    @foreach ($movies->take(8) as $movie)
                                        <a href="{{ route('movie_detail', $movie->id) }}"
                                            class="block bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="relative">
                                                <img src="{{ $movie->poster ? asset('storage/' . $movie->poster) : asset('default-movie-poster.jpg') }}"
                                                    alt="{{ $movie->judul }}" class="w-full h-48 sm:h-56 object-cover">
                                                @if ($movie->rating)
                                                    <div
                                                        class="absolute top-2 right-2 bg-green-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                                                        ⭐ {{ $movie->rating }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="p-4">
                                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 line-clamp-2"
                                                    title="{{ $movie->judul }}">
                                                    {{ $movie->judul }}
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-400 text-xs mb-2">
                                                    {{ $movie->tahun_rilis }}
                                                </p>
                                                @if ($movie->genre)
                                                    <span
                                                        class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full text-xs">
                                                        {{ $movie->genre }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-600 dark:text-gray-400">No movies available at the moment.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Fitur Section -->
                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                                Platform Fitur
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <div class="text-center">
                                    <div
                                        class="bg-blue-100 dark:bg-blue-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pencarian Lanjutan
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Temukan movie berdasarkan judul, genre, tahun, atau rating dengan fungsi pencarian
                                        yang canggih.
                                    </p>
                                </div>

                                <div class="text-center">
                                    <div
                                        class="bg-green-100 dark:bg-green-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Favorites</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Temukan movie yang disukai di sini.
                                    </p>
                                </div>

                                <div class="text-center">
                                    <div
                                        class="bg-purple-100 dark:bg-purple-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ratings & Reviews
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        Berikan rating movie dan review dari user lain untuk menemukan konten yang hebat.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Section -->
                        @guest
                            <div class="mt-16">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 text-center">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                        Pesan Tiket Sekarang
                                    </h2>
                                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
                                        Buat akun untuk memesan dan membuka semua fitur.
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                        <a href="{{ route('register') }}"
                                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition-colors duration-300">
                                            Sign Up Now
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('login') }}"
                                            class="inline-flex items-center px-6 py-3 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-900 dark:text-white font-semibold rounded-md transition-colors duration-300">
                                            Sign In
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript for Carousel -->
    @if ($movies->count() > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('movieCarousel');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const currentSlideSpan = document.getElementById('currentSlide');
                const totalSlidesSpan = document.getElementById('totalSlides');
                const indicators = document.querySelectorAll('.slide-indicator');

                let currentIndex = 0;
                let totalSlides = {{ ceil($movies->count() / 4) }}; // Desktop default

                // Perbarui total slide berdasarkan ukuran layar
                function updateTotalSlides() {
                    const isMobile = window.innerWidth < 768;
                    totalSlides = isMobile ? {{ ceil($movies->count() / 2) }} : {{ ceil($movies->count() / 4) }};
                    totalSlidesSpan.textContent = totalSlides;

                    // Tampilkan/sembunyikan slide yang sesuai
                    const desktopSlides = document.querySelectorAll('[data-slide^="desktop-"]');
                    const mobileSlides = document.querySelectorAll('[data-slide^="mobile-"]');

                    if (isMobile) {
                        desktopSlides.forEach(slide => slide.style.display = 'none');
                        mobileSlides.forEach(slide => slide.style.display = 'block');
                    } else {
                        desktopSlides.forEach(slide => slide.style.display = 'block');
                        mobileSlides.forEach(slide => slide.style.display = 'none');
                    }
                }

                function updateCarousel() {
                    const translateX = -currentIndex * 100;
                    carousel.style.transform = `translateX(${translateX}%)`;

                    // Update slide counter
                    currentSlideSpan.textContent = currentIndex + 1;

                    // Update indicators
                    indicators.forEach((indicator, index) => {
                        if (index === currentIndex) {
                            indicator.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                            indicator.classList.add('bg-gray-800', 'dark:bg-white');
                        } else {
                            indicator.classList.remove('bg-gray-800', 'dark:bg-white');
                            indicator.classList.add('bg-gray-300', 'dark:bg-gray-600');
                        }
                    });
                }

                function nextSlide() {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateCarousel();
                }

                function prevSlide() {
                    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                    updateCarousel();
                }

                // Event listeners
                nextBtn.addEventListener('click', nextSlide);
                prevBtn.addEventListener('click', prevSlide);

                // Indicator click events
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        currentIndex = index;
                        updateCarousel();
                    });
                });

                // Menangani perubahan ukuran window
                window.addEventListener('resize', () => {
                    updateTotalSlides();
                    // Reset to first slide on resize
                    currentIndex = 0;
                    updateCarousel();
                });

                // Initialize
                updateTotalSlides();
                updateCarousel();

                // Auto-slide (optional)
                setInterval(nextSlide, 5000); // Change slide every 5 seconds
            });
        </script>
    @endif
@endsection
