<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function confirmation(Request $request)
    {
        // Validasi akses langsung dari controller
        if (!$request->has('judul') || !$request->has('from_button') || $request->get('from_button') !== 'buy_now') {
            return redirect()->route('movie')->with('error', 'Akses tidak sah. Silakan beli tiket melalui halaman film.');
        }

        $movieTitle = $request->get('judul');

        // Validasi bahwa movie benar-benar ada di database
        $movie = Movie::where('judul', $movieTitle)->first();
        if (!$movie) {
            return redirect()->route('movie')->with('error', 'Film tidak ditemukan.');
        }

        // Set session flag untuk memvalidasi POST request nanti
        session([
            'purchase_access_granted' => true,
            'purchase_movie_title' => $movieTitle,
            'purchase_access_expires' => now()->addMinutes(10)->timestamp
        ]);

        return view('buy_ticket', compact('movieTitle', 'movie'));
    }

    public function getBookedSeats(Request $request)
    {
        $movieId = $request->get('movie_id');
        $jamTayang = $request->get('jam_tayang');

        if (!$movieId || !$jamTayang) {
            return response()->json(['error' => 'Movie ID dan jam tayang wajib diisi'], 400);
        }

        try {
            // Validasi format jam tayang
            if (!in_array($jamTayang, ['09:00', '13:00', '19:00'])) {
                return response()->json(['error' => 'Format jam tayang tidak valid'], 400);
            }

            // Validasi movie exists
            $movie = Movie::find($movieId);
            if (!$movie) {
                return response()->json(['error' => 'Film tidak ditemukan'], 404);
            }

            $kursiTerpesan = Ticket::where('movie_id', $movieId)
                ->where('jam_tayang', $jamTayang)
                ->get()
                ->pluck('kursi_dipilih')
                ->flatten()
                ->unique()
                ->values()
                ->toArray();

            return response()->json([
                'booked_seats' => $kursiTerpesan,
                'movie_title' => $movie->getAttribute('judul'),
                'showtime' => $jamTayang
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data kursi'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'jam_tayang' => 'required|in:09:00,13:00,19:00',
            'selected_seats' => 'required|array|min:1', // Minimal 1 kursi harus dipilih
            'selected_seats.*' => 'required|string|regex:/^[A-E][1-5]$/', // Format kursi: A1-E5
            'total' => 'required|numeric|min:25000',
            'quantity' => 'required|integer|min:1' // Quantity untuk validasi saja, tidak disimpan
        ], [
            // Pesan error 
            'username.required' => 'Username wajib diisi.',
            'judul.required' => 'Judul film wajib diisi.',
            'jam_tayang.required' => 'Jam tayang wajib dipilih.',
            'jam_tayang.in' => 'Jam tayang harus salah satu dari: 09:00, 13:00, atau 19:00.',
            'selected_seats.required' => 'Minimal 1 kursi harus dipilih.',
            'selected_seats.array' => 'Data kursi tidak valid.',
            'selected_seats.min' => 'Minimal 1 kursi harus dipilih.',
            'selected_seats.*.required' => 'Data kursi tidak boleh kosong.',
            'selected_seats.*.regex' => 'Format kursi tidak valid. Harus berupa A1-E5.',
            'total.required' => 'Total harga wajib diisi.',
            'total.numeric' => 'Total harga harus berupa angka.',
            'total.min' => 'Total harga minimal Rp 25.000.',
            'quantity.required' => 'Jumlah tiket wajib diisi.',
            'quantity.integer' => 'Jumlah tiket harus berupa angka bulat.',
            'quantity.min' => 'Jumlah tiket minimal 1.'
        ]);

        try {
            // Mulai database transaction untuk memastikan konsistensi data
            DB::beginTransaction();

            // Ambil data dari validated input
            $username = $validatedData['username'];
            $judulFilm = $validatedData['judul'];
            $jamTayang = $validatedData['jam_tayang'];
            $selectedSeats = $validatedData['selected_seats'];
            $total = $validatedData['total'];
            $quantity = $validatedData['quantity'];

            // Cari movie berdasarkan judul
            $movie = Movie::where('judul', $judulFilm)->first();

            if (!$movie) {
                DB::rollback();
                return redirect()->route('purchase.history')
                    ->with('error', 'Film tidak ditemukan.')
                    ->withInput();
            }

            // Pastikan user yang login sesuai dengan username di form
            $user = Auth::user();
            $userId = $user['id'];
            $userUsername = $user['username'];

            if ($userUsername !== $username) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Username tidak sesuai dengan user yang login.')
                    ->withInput();
            }

            // Validasi perhitungan total (harga per tiket = 25.000)
            $hargaPerTiket = 25000;
            $expectedTotal = $quantity * $hargaPerTiket;

            if ($total != $expectedTotal) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Total harga tidak sesuai dengan jumlah tiket.')
                    ->withInput();
            }

            // Cek apakah ada kursi yang sudah dipesan untuk jam tayang yang sama
            $kursiTerpesan = Ticket::where('movie_id', $movie->getAttribute('id'))
                ->where('jam_tayang', $jamTayang)
                ->get()
                ->pluck('kursi_dipilih')
                ->flatten()
                ->toArray();

            $konflikKursi = array_intersect($selectedSeats, $kursiTerpesan);

            if (!empty($konflikKursi)) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Kursi ' . implode(', ', $konflikKursi) . ' sudah dipesan untuk jam tayang ini. Silakan pilih kursi lain.')
                    ->withInput();
            }

            // Simpan data ticket ke database
            $ticket = Ticket::create([
                'user_id' => $userId,
                'movie_id' => $movie->getAttribute('id'),
                'jam_tayang' => $jamTayang,
                'kursi_dipilih' => $selectedSeats, // Akan disimpan sebagai JSON
                'total' => $total,
            ]);

            // Commit transaction jika semua berhasil
            DB::commit();

            // Menyimpan movieTitle untuk view
            $movieTitle = $judulFilm;

            // Redirect kembali ke halaman buy_ticket dengan pesan sukses
            return redirect()->back()
                ->with(
                    'success',
                    "Pembelian tiket berhasil! " .
                    "Film: {$judulFilm}, " .
                    "Jam: {$jamTayang}, " .
                    "Kursi: " . implode(', ', $selectedSeats) . ", " .
                    "Total: Rp " . number_format($total, 0, ',', '.')
                );

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembelian. Silakan coba lagi. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function history()
    {
        $ticket = Ticket::with('movie')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('history', compact('ticket'));
    }
    public function detail($id)
    {
        try {
            // Ambil data ticket dengan relasi movie
            // Pastikan hanya user yang memiliki ticket ini yang bisa mengaksesnya
            $ticket = Ticket::with('movie')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            // Jika ticket tidak ditemukan atau bukan milik user yang login
            if (!$ticket) {
                return redirect()->route('history')
                    ->with('error', 'Data ticket tidak ditemukan atau Anda tidak memiliki akses ke data ini.');
            }

            // Jika movie tidak ditemukan 
            if (!$ticket->movie) {
                return redirect()->route('history')
                    ->with('error', 'Data film terkait ticket ini tidak ditemukan.');
            }

            // Return view dengan data ticket
            return view('history-detail', compact('ticket'));

        } catch (\Exception $e) {
            return redirect()->route('history')
                ->with('error', 'Terjadi kesalahan saat mengambil detail ticket. Error: ' . $e->getMessage());
        }
    }
}