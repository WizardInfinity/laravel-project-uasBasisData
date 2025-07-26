{{-- resources/views/movie.blade.php --}}
@extends('layout')

{{-- Override title --}}
@section('title', 'Movie')

@section('content')
    <div class="px-4 py-6 sm:px-0">
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Page Header -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6 transition-colors duration-300">
                    <div class="px-4 py-5 sm:p-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            Koleksi Movie
                        </h1>
                        <p class="text-gray-600 dark:text-gray-300">
                            Temukan dan jelajahi koleksi movie yang fantastis
                        </p>
                    </div>
                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- Search Bar dan Sorting -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6 transition-colors duration-300">
                    <div class="px-4 py-5 sm:p-6">
                        <form method="GET" action="{{ route('movie') }}" id="movieForm">
                            <div class="flex flex-col gap-4">
                                <!-- Search Row -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="flex-1">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search berdasarkan judul, rating, dan tahun rilis..."
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300">
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                            Search
                                        </button>
                                        @if (request('search') || request('sort'))
                                            <a href="{{ route('movie') }}"
                                                class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                                                Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Sort Row -->
                                <div class="flex flex-col sm:flex-row gap-4 items-center">
                                    <label class="text-gray-700 dark:text-gray-300 font-medium whitespace-nowrap">
                                        Sortir berdasarkan:
                                    </label>
                                    <div class="flex-1 sm:max-w-xs">
                                        <select name="sort"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300"
                                            onchange="this.form.submit()">
                                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                                                Terbaru Ditambahkan
                                            </option>
                                            <option value="tahun_rilis_terbaru"
                                                {{ request('sort') == 'tahun_rilis_terbaru' ? 'selected' : '' }}>
                                                Tahun Rilis (Terbaru)
                                            </option>
                                            <option value="tahun_rilis_terlama"
                                                {{ request('sort') == 'tahun_rilis_terlama' ? 'selected' : '' }}>
                                                Tahun Rilis (Terlama)
                                            </option>
                                            <option value="judul_az" {{ request('sort') == 'judul_az' ? 'selected' : '' }}>
                                                Judul (A-Z)
                                            </option>
                                            <option value="judul_za" {{ request('sort') == 'judul_za' ? 'selected' : '' }}>
                                                Judul (Z-A)
                                            </option>
                                            <option value="rating_tinggi"
                                                {{ request('sort') == 'rating_tinggi' ? 'selected' : '' }}>
                                                Rating (Tertinggi)
                                            </option>
                                            <option value="rating_rendah"
                                                {{ request('sort') == 'rating_rendah' ? 'selected' : '' }}>
                                                Rating (Terendah)
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results Info -->
                @if (request('search') || request('sort'))
                    <div class="mb-4">
                        <p class="text-gray-600 dark:text-gray-300">
                            @if (request('search'))
                                Ditemukan {{ $movies->total() }} hasil untuk "{{ request('search') }}"
                            @else
                                Showing {{ $movies->total() }} movie(s)
                            @endif

                            @php
                                $sortLabels = [
                                    'terbaru' => 'Terbaru Ditambahkan',
                                    'tahun_rilis_terbaru' => 'Tahun Rilis (Terbaru)',
                                    'tahun_rilis_terlama' => 'Tahun Rilis (Terlama)',
                                    'judul_az' => 'Judul (A-Z)',
                                    'judul_za' => 'Judul (Z-A)',
                                    'rating_tinggi' => 'Rating (Tertinggi)',
                                    'rating_rendah' => 'Rating (Terendah)',
                                ];
                                $currentSort = request('sort', 'terbaru');
                            @endphp

                            @if (request('sort') && request('sort') != 'terbaru')
                                - Sortir berdasarkan {{ $sortLabels[$currentSort] ?? 'Terbaru Ditambahkan' }}
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Movie Grid -->
                @if ($movies->count() > 0)
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($movies as $movie)
                            <div
                                class="bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->judul }}"
                                    class="w-full h-64 md:h-80 object-cover">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 truncate">
                                        {{ $movie->judul }}</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                                        {{ Str::limit($movie->sinopsis, 100) }}</p>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-yellow-500 text-sm font-medium">⭐
                                            {{ number_format($movie->rating, 1) }}</span>
                                        <span
                                            class="text-gray-500 dark:text-gray-400 text-sm">{{ $movie->tahun_rilis }}</span>
                                    </div>

                                    @auth
                                        @if (auth()->user()->email === 'admin@email.com')
                                            <div class="grid grid-cols-3 gap-2">
                                                <a href="{{ route('admin.movie.edit', ['id' => $movie->id]) }}"
                                                    class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg transition-colors duration-200 font-medium text-xs text-center flex items-center justify-center">
                                                    Edit
                                                </a>
                                                <button
                                                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg transition-colors duration-200 font-medium text-xs"
                                                    onclick="buyTicket('{{ $movie->judul }}', {{ $movie->id }})">
                                                    Beli Tiket
                                                </button>
                                                <form id="delete-form-{{ $movie->id }}"
                                                    action="{{ route('admin.movie.destroy', $movie->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="button"
                                                    onclick="confirmDelete({{ $movie->id }}, '{{ $movie->judul }}')"
                                                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg transition-colors duration-200 font-medium text-xs">
                                                    Hapus
                                                </button>
                                            </div>
                                        @else
                                            <div class="w-full">
                                                <button
                                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg transition-colors duration-200 font-medium text-sm"
                                                    onclick="buyTicket('{{ $movie->judul }}', {{ $movie->id }})">
                                                    Beli tiket
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        <!-- Guest User View: 1 button (Login prompt) -->
                                        <div class="w-full">
                                            <button
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg transition-colors duration-200 font-medium text-sm"
                                                onclick="showLoginPrompt()">
                                                Beli tiket
                                            </button>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($movies->hasPages())
                        <div class="mt-8">
                            {{ $movies->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="text-center py-12">
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No movies found</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                @if (request('search'))
                                    Tidak ada movie yang cocok dengan pencarian Anda "{{ request('search') }}". Coba keyword yang berbeda.
                                @else
                                    Belum ada movie dalam koleksi.
                                @endif
                            </p>
                            @if (request('search') || request('sort'))
                                <a href="{{ route('movie') }}"
                                    class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                    Tampilkan semua movie
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.css">
    <script>
        function buyTicket(movieTitle, movieId) {
            Swal.fire({
                title: 'Konfirmasi Pembelian',
                text: `Ingin membeli tiket untuk "${movieTitle}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Beli Sekarang',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Redirecting ke halaman pembelian...',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                        color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        window.location.href = `/purchase?judul=${encodeURIComponent(movieTitle)}&from_button=buy_now`;
                    }, 1000);
                    
                    console.log('Redirecting to buy ticket for movie:', movieTitle);
                } else if (result.isDismissed) {
                    console.log('User cancelled ticket purchase for:', movieTitle);
                }
            });
        }

        function showLoginPrompt() {
            Swal.fire({
                title: 'Login Dibutuhkan',
                text: 'Anda perlu login terlebih dahulu untuk membeli tiket. Apakah Anda ingin membuka halaman login?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Go to Login',
                cancelButtonText: 'Maybe Later',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Redirecting...',
                        text: 'Membawa Anda ke halaman login...',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                        color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Redirect ke halaman login
                    setTimeout(() => {
                        window.location.href = '{{ route('login') }}';
                    }, 800);
                }
            });
        }

        function confirmDelete(movieId, movieTitle) {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: `Anda akan menghapus "${movieTitle}". Action ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, hapus saja!',
                cancelButtonText: 'Cancel',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: `Menghapus "${movieTitle}" dari koleksi...`,
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                        color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    document.getElementById('delete-form-' + movieId).submit();
                }
            });
        }

        @if (session('success'))
            // Wait for DOM to be ready
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    Swal.fire({
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonColor: '#10B981',
                        confirmButtonText: 'Awesome!',
                        timer: 5000,
                        timerProgressBar: true,
                        background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                        color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
                    });
                }, 500);
            });
        @endif

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    console.log('Theme changed to:', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>
@endsection