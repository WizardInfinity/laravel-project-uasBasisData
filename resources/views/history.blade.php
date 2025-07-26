{{-- resources/views/history.blade.php --}}
@extends('layout')

@section('title', 'History')

@section('content')
    <div class="px-4 sm:px-0">
        <main class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mb-2">
                        Riwayat Pembelian Tiket
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Berikut adalah daftar tiket yang telah dibeli
                    </p>
                </div>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mb-6 rounded px-4 py-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 transition-colors duration-300"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="mb-6 rounded px-4 py-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 transition-colors duration-300"
                        role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($ticket && $ticket->count())
                    <!-- History Cards -->
                    <div class="space-y-6">
                        @foreach ($ticket as $purchase)
                            <a href="{{ route('history.detail', $purchase->id) }}" class="block">
                                <div
                                    class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 cursor-pointer">
                                    <div class="p-6">
                                        <div class="mb-4 flex items-center justify-between">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                                {{ $purchase->movie->judul }}
                                            </h3>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $purchase->created_at->format('d M Y') }}
                                            </span>
                                        </div>

                                        @if ($purchase->movie->genre || $purchase->movie->durasi)
                                            <div
                                                class="mb-4 rounded-md bg-gray-50 dark:bg-gray-700 p-3 transition-colors duration-300">
                                                <div class="flex items-center space-x-4 text-sm">
                                                    @if ($purchase->movie->genre)
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:text-blue-300">
                                                            {{ $purchase->movie->genre }}
                                                        </span>
                                                    @endif
                                                    @if ($purchase->movie->durasi)
                                                        <span
                                                            class="inline-flex items-center text-gray-600 dark:text-gray-300">
                                                            <svg class="mr-1 inline h-4 w-4" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            {{ $purchase->movie->durasi }} menit
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mb-4 grid gap-4 md:grid-cols-3">
                                            <!-- Jam Tayang -->
                                            <div class="flex items-center">
                                                <svg class="mr-2 h-5 w-5 text-blue-500 dark:text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Jam Tayang</p>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($purchase->jam_tayang)->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Total Harga -->
                                            <div class="flex items-center">
                                                <svg class="mr-2 h-5 w-5 text-green-500 dark:text-green-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                    </path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Harga</p>
                                                    <p class="font-bold text-green-600 dark:text-green-400">
                                                        Rp {{ number_format($purchase->total, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Jumlah Tiket -->
                                            <div class="flex items-center">
                                                <svg class="mr-2 h-5 w-5 text-purple-500 dark:text-purple-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                                    </path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Tiket</p>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ intval($purchase->total / 25000) }} tiket
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="mt-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-600 pt-3">
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                ID Transaksi: #{{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }}
                                            </p>
                                            <div class="flex items-center text-blue-600 dark:text-blue-400">
                                                <span class="mr-2 text-sm font-medium">Klik untuk detail</span>
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <!-- Tampilkan jika belum pernah beli tiket -->
                    <div class="py-12 text-center">
                        <div class="mb-4 mx-auto h-24 w-24 text-gray-400 dark:text-gray-500">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                            Belum Ada Riwayat Pembelian Ticket
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Anda belum pernah membeli tiket. Pesan tiket sekarang.
                        </p>
                        <a href="{{ route('movie') ?? '/' }}"
                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 transition-colors duration-200">
                            Lihat Film
                        </a>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </main>
    </div>
@endsection
