{{-- resources/views/history-detail.blade.php --}}
@extends('layout')

@section('title', 'Detail Pembelian Tiket')

@section('content')
    <div class="px-4 sm:px-0">
        <main class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="mb-2 text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                        Detail Pembelian Tiket
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $ticket->movie->judul }}
                    </p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        ID Transaksi: #{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <!-- Ringkasan pembelian -->
                <div
                    class="mb-8 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-lg transition-colors duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Jam Tayang -->
                        <div class="text-center">
                            <div class="mb-2 flex justify-center">
                                <svg class="h-8 w-8 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jam Tayang</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ \Carbon\Carbon::parse($ticket->jam_tayang)->format('H:i') }}
                            </p>
                        </div>
                        <!-- Jumlah Tiket -->
                        <div class="text-center">
                            <div class="mb-2 flex justify-center">
                                <svg class="h-8 w-8 text-purple-500 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Tiket</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ count($ticket->kursi_dipilih) }} tiket
                            </p>
                        </div>
                        <!-- Nomor Kursi -->
                        <div class="text-center">
                            <div class="mb-2 flex justify-center">
                                <svg class="h-8 w-8 text-orange-500 dark:text-orange-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 15.546c-.523 0-.969.395-.998.916l-.035.142A3.5 3.5 0 0116.5 19.5h-9A3.5 3.5 0 014.033 16.604l-.035-.142C3.969 15.941 3.523 15.546 3 15.546v-7.092c.523 0 .969-.395.998-.916l.035-.142A3.5 3.5 0 017.5 4.5h9a3.5 3.5 0 013.467 2.896l.035.142c.029.521.475.916.998.916v7.092z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nomor Kursi</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ implode(', ', $ticket->kursi_dipilih) }}
                            </p>
                        </div>
                        <!-- Total Harga -->
                        <div class="text-center">
                            <div class="mb-2 flex justify-center">
                                <svg class="h-8 w-8 text-green-500 dark:text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Harga</p>
                            <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                Rp {{ number_format($ticket->total, 0, ',', '.') }}
                            </p>
                        </div>
                        <!-- Tanggal Beli -->
                        <div class="text-center">
                            <div class="mb-2 flex justify-center">
                                <svg class="h-8 w-8 text-yellow-500 dark:text-yellow-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v2a2 2 0 002 2h4a2 2 0 002-2v-2M8 11v2a2 2 0 002 2h4a2 2 0 002-2v-2">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Beli</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ $ticket->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Film -->
                @if ($ticket->movie->genre || $ticket->movie->durasi)
                    <div
                        class="mb-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-700 dark:to-purple-800 p-6 text-white transition-colors duration-300">
                        <h3 class="mb-4 text-xl font-bold">Informasi Film</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-blue-100 text-sm">Judul Film</p>
                                <p class="text-lg font-semibold">{{ $ticket->movie->judul }}</p>
                            </div>
                            @if ($ticket->movie->genre)
                                <div>
                                    <p class="text-blue-100 text-sm">Genre</p>
                                    <p class="font-semibold">{{ $ticket->movie->genre }}</p>
                                </div>
                            @endif
                            @if ($ticket->movie->durasi)
                                <div>
                                    <p class="text-blue-100 text-sm">Durasi</p>
                                    <p class="font-semibold">{{ $ticket->movie->durasi }} menit</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Tiket -->
                <div class="mb-8">
                    <h3 class="mb-6 text-center text-2xl font-bold text-gray-900 dark:text-gray-100">Tiket Anda</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($ticket->kursi_dipilih as $index => $kursi)
                            <div
                                class="overflow-hidden rounded-lg border-l-4 border-blue-500 dark:border-blue-400 bg-white dark:bg-gray-800 shadow-lg hover:scale-105 transition-transform duration-200">
                                <!-- Header Tiket -->
                                <div
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 px-6 py-4">
                                    <div class="flex justify-between text-white">
                                        <div>
                                            <h4 class="text-lg font-bold">CINEMA TICKET</h4>
                                            <p class="text-xs text-blue-100">Kursi {{ $kursi }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-blue-100">ID Transaksi</p>
                                            <p class="font-mono text-sm">
                                                #{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Body Tiket -->
                                <div class="px-6 py-4">
                                    <h5 class="mb-1 text-lg font-bold text-gray-900 dark:text-gray-100">
                                        {{ $ticket->movie->judul }}</h5>
                                    @if ($ticket->movie->genre)
                                        <span
                                            class="inline-block rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            {{ $ticket->movie->genre }}
                                        </span>
                                    @endif
                                    <div class="mt-3 space-y-3">
                                        <!-- Nomor Kursi -->
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 15.546c-.523 0-.969.395-.998.916l-.035.142A3.5 3.5 0 0116.5 19.5h-9A3.5 3.5 0 014.033 16.604l-.035-.142C3.969 15.941 3.523 15.546 3 15.546v-7.092c.523 0 .969-.395.998-.916l.035-.142A3.5 3.5 0 017.5 4.5h9a3.5 3.5 0 013.467 2.896l.035.142c.029.521.475.916.998.916v7.092z">
                                                </path>
                                            </svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">
                                                Kursi {{ $kursi }}
                                            </p>
                                        </div>
                                        <!-- Jam Tayang -->
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">
                                                {{ \Carbon\Carbon::parse($ticket->jam_tayang)->format('H:i') }}
                                            </p>
                                        </div>
                                        <!-- Tanggal -->
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v2a2 2 0 002 2h4a2 2 0 002-2v-2">
                                                </path>
                                            </svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">
                                                {{ $ticket->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        <!-- Harga per Tiket -->
                                        <div class="flex items-center">
                                            <svg class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                </path>
                                            </svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Rp 25.000</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Footer Tiket -->
                                <div
                                    class="border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-6 py-3">
                                    <div class="flex justify-between items-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Berlaku untuk 1 orang</p>
                                        <div class="flex items-center">
                                            <div class="mr-2 h-2 w-2 rounded-full bg-green-500 dark:bg-green-400"></div>
                                            <span
                                                class="text-xs font-medium text-green-600 dark:text-green-400">Valid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4 text-center">
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('purchase.history') }}"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700 transition-colors duration-200">
                            Kembali ke Riwayat
                        </a>
                        <button onclick="showQRCode()"
                            class="inline-flex items-center rounded-lg bg-green-600 px-6 py-3 font-medium text-white hover:bg-green-700 transition-colors duration-200">
                            Tampilkan QR Code
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Simpan tiket ini sebagai bukti pembelian
                    </p>
                </div>
            </div>
        </main>
    </div>

    <!-- QR Code Modal -->
    <div id="qrModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="mx-4 max-w-sm rounded-lg bg-white dark:bg-gray-800 p-8">
            <div class="text-center">
                <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-gray-100">QR Code Tiket</h3>
                <div class="mb-4 rounded-lg bg-white p-4">
                    <img id="qrCodeImage" src="" alt="QR Code" class="mx-auto w-48 h-48">
                </div>
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    Scan QR code
                </p>
                <button onclick="closeQRCode()"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body,
            .bg-gray-50,
            .bg-gray-900,
            .dark\:bg-gray-800,
            .dark\:bg-gray-700 {
                background: white !important;
            }

            .text-white,
            .dark\:text-gray-100 {
                color: black !important;
            }

            .shadow-lg {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24) !important;
            }

            .border {
                border: 1px solid #ccc !important;
            }
        }
    </style>

    <!-- QR Code Script -->
    <script>
        function showQRCode() {
            const qrUrl = 'https://youtu.be/dQw4w9WgXcQ?si=avRWcGfWlrkC_aIq';
            const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrUrl)}`;
            document.getElementById('qrCodeImage').src = qrApiUrl;
            document.getElementById('qrModal').classList.remove('hidden');
            document.getElementById('qrModal').classList.add('flex');
        }

        function closeQRCode() {
            document.getElementById('qrModal').classList.add('hidden');
            document.getElementById('qrModal').classList.remove('flex');
        }

        document.getElementById('qrModal').addEventListener('click', function(e) {
            if (e.target === this) closeQRCode();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeQRCode();
        });
    </script>
@endsection
