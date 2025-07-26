{{-- resources/views/movie_detail.blade.php --}}
@extends('layout')

{{-- Override title --}}
@section('title', 'Detail Movie - ' . $movie->judul)

@section('content')
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Tombol Kembali -->
            <div class="mb-6">
                <button onclick="history.back()"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </button>
            </div>

            <!-- Card Detail Movie -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-colors duration-300">
                <div class="lg:flex">
                    <!-- Movie Poster -->
                    <div class="lg:w-1/3 xl:w-1/4">
                        <div class="h-64 sm:h-80 lg:h-full min-h-[400px] relative">
                            @if ($movie->poster)
                                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->judul }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center">
                                    <div class="text-center text-gray-600 dark:text-gray-300">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-sm">Tidak Ada Poster Tersedia</p>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent lg:hidden"></div>
                        </div>
                    </div>

                    <!-- Informasi Movie -->
                    <div class="lg:w-2/3 xl:w-3/4 p-6 lg:p-8">
                        <!-- Judul -->
                        <div class="mb-6">
                            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                                {{ $movie->judul }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $movie->tahun_rilis }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <span
                                        class="text-yellow-500 font-semibold">{{ number_format($movie->rating, 1) }}</span>
                                    <span class="text-gray-500">/10</span>
                                </span>
                            </div>
                        </div>

                        <!-- Sinopsis -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Sinopsis</h2>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                                {{ $movie->sinopsis }}
                            </p>
                        </div>

                        <!-- Statistik Movie -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 text-center transition-colors duration-300">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $movie->rating }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Rating</div>
                            </div>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 text-center transition-colors duration-300">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $movie->tahun_rilis }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Tahun Rilis</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="buyTicket()"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                    </path>
                                </svg>
                                Beli Tiket
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function buyTicket() {
            const isAuthenticated = @json(auth()->check());
            const movieTitle = @json($movie->judul);

            if (!isAuthenticated) {
                Swal.fire({
                    title: 'Login Diperlukan!',
                    text: 'Anda harus login terlebih dahulu untuk membeli tiket.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                    color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('login') }}';
                    }
                });
            } else {
                Swal.fire({
                    title: 'Beli Tiket?',
                    text: `Apakah Anda yakin ingin membeli tiket untuk film "${movieTitle}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Beli Tiket!',
                    cancelButtonText: 'Batal',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                    color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            `/purchase?judul=${encodeURIComponent(movieTitle)}&from_button=buy_now`;
                    }
                });
            }
        }

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>
@endsection
