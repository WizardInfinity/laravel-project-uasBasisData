{{-- resources/views/buy_ticket.blade.php --}}
@extends('layout')

{{-- Override title --}}
@section('title', 'Buy Ticket')

@section('content')
    <div class="px-4 sm:px-0">
        <!-- Main Content -->
        <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                        Konfirmasi Pembelian Tiket
                    </h2>
                </div>

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('buy_ticket.store') }}" method="POST">
                    @csrf

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Username
                        </label>
                        <div class="mt-1">
                            <input id="username" name="username" type="text" required readonly
                                value="{{ auth()->user()->username ?? old('username') }}"
                                class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-white transition-colors duration-300 @error('username') border-red-500 @enderror">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Judul Film
                        </label>
                        <div class="mt-1">
                            <input id="judul" name="judul" type="text" required readonly
                                value="{{ $movieTitle ?? old('judul') }}"
                                class="appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-white transition-colors duration-300 @error('judul') border-red-500 @enderror">
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" id="movie_id" value="{{ $movie->id ?? '' }}">
                    </div>

                        <div class="flex space-x-3">
                            @foreach (['09:00', '13:00', '19:00'] as $time)
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jam_tayang" value="{{ $time }}"
                                        class="sr-only peer showtime-radio"
                                        {{ old('jam_tayang') == $time ? 'checked' : '' }}>
                                    <div
                                        class="flex items-center justify-center py-3 px-4 rounded-full border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white">
                                        <span
                                            class="text-sm font-medium">{{ substr($time, 0, 2) }}.{{ substr($time, 3) }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                    <!-- Card Pemilihan Kursi (Tersembunyi secara default) -->
                    <div id="seat-selection-card"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Kursi</h3>

                        <div id="seat-selection-container">
                            <!-- Layar -->
                            <div class="mb-8">
                                <div
                                    class="w-full h-8 bg-gradient-to-r from-gray-400 via-gray-200 to-gray-400 dark:from-gray-600 dark:via-gray-400 dark:to-gray-600 rounded-xl flex items-center justify-center shadow-lg border border-gray-300 dark:border-gray-500">
                                    <span
                                        class="text-sm font-bold text-gray-700 dark:text-gray-200 tracking-widest">LAYAR</span>
                                </div>
                            </div>

                            <!-- Grid kursi -->
                            <div class="seat-container mb-6">
                                <div class="grid grid-cols-5 gap-2 sm:gap-3 max-w-sm sm:max-w-md mx-auto">
                                    @php
                                        $rows = ['A', 'B', 'C', 'D', 'E'];
                                        $columns = [1, 2, 3, 4, 5];
                                    @endphp
                                    @foreach ($rows as $row)
                                        @foreach ($columns as $col)
                                            @php
                                                $seatId = $row . $col;
                                            @endphp
                                            <label class="cursor-pointer seat-label" data-seat="{{ $seatId }}">
                                                <input type="checkbox" name="selected_seats[]" value="{{ $seatId }}"
                                                    class="sr-only peer seat-checkbox" data-seat="{{ $seatId }}">
                                                <div
                                                    class="seat-item w-10 h-10 sm:w-12 sm:h-12 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 hover:shadow-md hover:scale-105 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">
                                                    <span
                                                        class="text-xs font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-white">{{ $seatId }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>

                            <!-- Simbol kursi -->
                            <div class="flex flex-wrap justify-center gap-3 sm:gap-4 text-xs mb-6">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-4 h-4 border-2 border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 rounded">
                                    </div>
                                    <span class="text-gray-600 dark:text-gray-400">Tersedia</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 border-2 border-blue-500 bg-blue-500 rounded"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Dipilih</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 border-2 border-red-400 bg-red-400 rounded"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Terisi</span>
                                </div>
                            </div>

                            <!-- Tampilan Kursi Terpilih -->
                            <div
                                class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Kursi dipilih: </span>
                                <span id="selected-seats-display"
                                    class="text-sm font-semibold text-blue-600 dark:text-blue-400">-</span>
                            </div>
                        </div>

                        @error('selected_seats')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Card Harga Total (Tersembunyi secara default) -->
                    <div id="total-price-card"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pembelian</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Jumlah Tiket:</span>
                                <span id="quantity_display" class="font-semibold text-blue-600 dark:text-blue-400">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Harga per Tiket:</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Rp 25,000</span>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                                <span id="total_display" class="text-lg font-bold text-blue-600 dark:text-blue-400">Rp
                                    0</span>
                            </div>
                        </div>

                        <input type="hidden" name="total" id="total" value="0">
                        <input type="hidden" name="quantity" id="quantity" value="0">

                        @error('total')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" id="submit-btn" disabled
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 data-[enabled]:bg-blue-600 data-[enabled]:hover:bg-blue-700 data-[enabled]:focus:ring-blue-500 data-[enabled]:cursor-pointer">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <!-- Shopping cart icon -->
                                <svg class="h-5 w-5 text-gray-300 group-data-[enabled]:text-blue-300"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path
                                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                            </span>
                            Buy Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hargaPerTiket = 25000;
            let selectedSeats = [];
            let bookedSeats = [];

            const totalInput = document.getElementById('total');
            const quantityInput = document.getElementById('quantity');
            const totalDisplay = document.getElementById('total_display');
            const quantityDisplay = document.getElementById('quantity_display');
            const selectedSeatsDisplay = document.getElementById('selected-seats-display');
            const submitBtn = document.getElementById('submit-btn');
            const seatCheckboxes = document.querySelectorAll('.seat-checkbox');
            const showtimeRadios = document.querySelectorAll('.showtime-radio');
            const movieId = document.getElementById('movie_id').value;
            const seatSelectionCard = document.getElementById('seat-selection-card');
            const totalPriceCard = document.getElementById('total-price-card');

            function updateDisplays() {
                const quantity = selectedSeats.length;
                const total = quantity * hargaPerTiket;

                totalInput.value = total;
                quantityInput.value = quantity;
                quantityDisplay.textContent = quantity;
                totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');

                // Perbarui tampilan kursi yang dipilih
                if (selectedSeats.length > 0) {
                    selectedSeatsDisplay.textContent = selectedSeats.join(', ');
                } else {
                    selectedSeatsDisplay.textContent = '-';
                }

                // Tampilkan/sembunyikan card harga total berdasarkan pemilihan kursi
                if (quantity > 0) {
                    totalPriceCard.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.setAttribute('data-enabled', 'true');
                } else {
                    totalPriceCard.classList.add('hidden');
                    submitBtn.disabled = true;
                    submitBtn.removeAttribute('data-enabled');
                }
            }

            function resetSeats() {
                selectedSeats = [];
                seatCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    checkbox.disabled = false;

                    const seatLabel = checkbox.closest('.seat-label');
                    const seatItem = seatLabel.querySelector('.seat-item');

                    // Setel ulang ke default
                    seatItem.className =
                        'seat-item w-10 h-10 sm:w-12 sm:h-12 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 hover:shadow-md hover:scale-105 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white peer-disabled:opacity-50 peer-disabled:cursor-not-allowed';

                    seatLabel.style.cursor = 'pointer';
                });
                updateDisplays();
            }

            function updateBookedSeats(bookedSeatsArray) {
                bookedSeats = bookedSeatsArray;

                seatCheckboxes.forEach(checkbox => {
                    const seatId = checkbox.dataset.seat;
                    const seatLabel = checkbox.closest('.seat-label');
                    const seatItem = seatLabel.querySelector('.seat-item');

                    if (bookedSeats.includes(seatId)) {
                        // Tandai sebagai sudah dipesan (merah)
                        checkbox.disabled = true;
                        checkbox.checked = false;
                        seatLabel.style.cursor = 'not-allowed';
                        seatItem.className =
                            'seat-item w-10 h-10 sm:w-12 sm:h-12 border-2 border-red-400 bg-red-400 rounded-lg flex items-center justify-center transition-all duration-200 opacity-75';

                        // Hapus dari kursi yang dipilih jika sudah dipilih
                        selectedSeats = selectedSeats.filter(seat => seat !== seatId);
                    } else {
                        // Tandai sebagai tersedia
                        checkbox.disabled = false;
                        seatLabel.style.cursor = 'pointer';
                        if (!selectedSeats.includes(seatId)) {
                            seatItem.className =
                                'seat-item w-10 h-10 sm:w-12 sm:h-12 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 hover:shadow-md hover:scale-105 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white peer-disabled:opacity-50 peer-disabled:cursor-not-allowed';
                        }
                    }
                });

                updateDisplays();
            }

            function fetchBookedSeats(jamTayang) {
                if (!movieId || !jamTayang) return;

                fetch(`{{ route('buy_ticket.booked_seats') }}?movie_id=${movieId}&jam_tayang=${jamTayang}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.booked_seats) {
                            updateBookedSeats(data.booked_seats);
                        } else {
                            console.error('Error fetching booked seats:', data.error);
                            updateBookedSeats([]);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        updateBookedSeats([]);
                    });
            }

            showtimeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        // Tunjukkan card pemilihan tempat duduk
                        seatSelectionCard.classList.remove('hidden');

                        resetSeats();
                        fetchBookedSeats(this.value);
                    }
                });
            });

            // Menangani pemilihan kursi
            seatCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatId = this.value;

                    if (this.checked) {
                        if (!bookedSeats.includes(seatId)) {
                            selectedSeats.push(seatId);
                        }
                    } else {
                        selectedSeats = selectedSeats.filter(seat => seat !== seatId);
                    }

                    updateDisplays();
                });
            });

            // Initial setup
            updateDisplays();

            // Cek apakah ada jam tayang yang dipilih dan tunjukkan card yang sesuai
            const selectedShowtime = document.querySelector('.showtime-radio:checked');
            if (selectedShowtime) {
                seatSelectionCard.classList.remove('hidden');
                fetchBookedSeats(selectedShowtime.value);
            }

            // Periksa pesan sukses dari sesi dengan tema dinamis
            @if (session('success'))
                Swal.fire({
                    title: 'Pembelian Ticket Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'Lihat Riwayat',
                    confirmButtonColor: '#10B981',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                    color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('purchase.history') }}';
                    }
                });
            @endif

            // Update SweetAlert theme when dark mode changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        // Theme has changed, any open SweetAlert2 modals will automatically use the new theme
                        console.log('Theme changed to:', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                    }
                });
            });
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    
        function showConfirmationDialog(message, callback) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
            }).then((result) => {
                if (result.isConfirmed && callback) {
                    callback();
                }
            });
        }

        function showErrorDialog(title, message) {
            Swal.fire({
                title: title || 'Error!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#DC2626',
                confirmButtonText: 'OK',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
            });
        }

        function showLoadingDialog(title, message) {
            Swal.fire({
                title: title || 'Processing...',
                text: message || 'Please wait...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827',
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function showInfoDialog(title, message) {
            Swal.fire({
                title: title,
                text: message,
                icon: 'info',
                confirmButtonColor: '#3B82F6',
                confirmButtonText: 'OK',
                background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                color: document.documentElement.classList.contains('dark') ? '#F9FAFB' : '#111827'
            });
        }

        // Form validasi dengan SweetAlert2
        function validatePurchaseForm() {
            const selectedSeats = document.querySelectorAll('.seat-checkbox:checked');
            const selectedShowtime = document.querySelector('.showtime-radio:checked');

            if (!selectedShowtime) {
                showErrorDialog('Pilih Jam Tayang', 'Silakan pilih jam tayang terlebih dahulu.');
                return false;
            }

            if (selectedSeats.length === 0) {
                showErrorDialog('Pilih Kursi', 'Silakan pilih minimal satu kursi.');
                return false;
            }

            return true;
        }

        function submitPurchaseWithConfirmation() {
            if (!validatePurchaseForm()) {
                return false;
            }

            const selectedSeats = Array.from(document.querySelectorAll('.seat-checkbox:checked')).map(cb => cb.value);
            const selectedShowtime = document.querySelector('.showtime-radio:checked').value;
            const total = document.getElementById('total_display').textContent;

            showConfirmationDialog(
                `Konfirmasi pembelian tiket untuk kursi ${selectedSeats.join(', ')} pada jam ${selectedShowtime}. Total: ${total}`,
                function() {
                    showLoadingDialog('Memproses Pembelian', 'Mohon tunggu sementara kami memproses pembelian Anda...');
                    
                    // Submit the form
                    setTimeout(() => {
                        document.getElementById('purchase-form').submit();
                    }, 1000);
                }
            );
        }
    </script>
@endsection
