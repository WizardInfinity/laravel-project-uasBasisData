<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.movie_create');
    }

    public function store(Request $request)
    {
        // Ambil input untuk validasi custom
        $judul = $request->input('judul');
        $tahunRilis = $request->input('tahun_rilis');

        // Validasi input dengan custom rule - judul harus unik
        $data = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
                // Judul tidak boleh sama persis 
                Rule::unique('movies', 'judul')
            ],
            'sinopsis' => 'required|string',
            'rating' => 'required|numeric|min:1|max:10',
            'tahun_rilis' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB
        ], [
            // Custom error messages
            'judul.unique' => 'Movie dengan judul "' . $judul . '" sudah ada dalam database. Silakan gunakan judul yang berbeda.',
        ]);

        // Simpan file poster jika ada
        if ($request->hasFile('poster')) {
            // simpan di storage/app/public/posters
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $path;
        }

        // Simpan movie ke database
        Movie::create($data);

        // Redirect kembali ke form dengan pesan sukses
        return redirect()
            ->route('admin.movie.create')
            ->with('success', 'Movie "' . $data['judul'] . '" berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movie_edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $judul = $request->input('judul');
        $tahunRilis = $request->input('tahun_rilis');

        // Validasi input 
        $data = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
                Rule::unique('movies', 'judul')->ignore($movie->getAttribute('id'))
            ],
            'sinopsis' => 'required|string',
            'rating' => 'required|numeric|min:1|max:10',
            'tahun_rilis' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.unique' => 'Movie dengan judul "' . $judul . '" sudah ada dalam database.',
        ]);

        // Jika ada poster baru, hapus yang lama lalu simpan
        if ($request->hasFile('poster')) {
            // hapus file lama jika ada
            if ($movie->getAttribute('poster') && Storage::disk('public')->exists($movie->getAttribute('poster'))) {
                Storage::disk('public')->delete($movie->getAttribute('poster'));
            }
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $path;
        }

        // Update data
        $movie->update($data);

        // Redirect ke halaman edit dengan pesan sukses
        return redirect()
            ->route('admin.movie.edit', $movie->getAttribute('id'))
            ->with('success', 'Movie "' . $data['judul'] . '" berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari movie, jika tidak ada maka throw 404
        $movie = Movie::findOrFail($id);

        // Hapus file poster dari storage jika ada
        $posterPath = $movie->getAttribute('poster');
        if ($posterPath && Storage::disk('public')->exists($posterPath)) {
            Storage::disk('public')->delete($posterPath);
        }

        // Hapus record dari database
        $movie->delete();

        // Redirect balik ke halaman movie dengan flash message
        return redirect()
            ->route('movie')
            ->with('success', 'Movie berhasil dihapus.');
    }

    public function dataUser(Request $request)
    {
        // Get search parameter
        $search = $request->get('search');

        // Mengambil data user beserta pembelian tiket mereka
        $users = User::with([
            'ticket' => function ($query) {
                $query->with('movie'); // Relasi ke tabel movies
            }
        ])->get();

        // Query dengan search dan pagination
        $ticketQuery = DB::table('ticket')
            ->join('users', 'ticket.user_id', '=', 'users.id')
            ->join('movies', 'ticket.movie_id', '=', 'movies.id')
            ->select(
                'ticket.id as ticket_id',
                'users.id as user_id',
                'users.username',
                'users.email',
                'movies.judul as movie_title',
                'ticket.jam_tayang',
                'ticket.total',
                'ticket.created_at as tanggal_ticket'
            );

        // Terapkan filter pencarian jika parameter pencarian ada
        if ($search) {
            $ticketQuery->where(function ($query) use ($search) {
                $query->where('users.username', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                    ->orWhere('movies.judul', 'LIKE', '%' . $search . '%');
            });
        }

        // Dapatkan paginated results
        $ticketData = $ticketQuery
            ->orderBy('ticket.created_at', 'desc')
            ->paginate(10)
            ->appends(request()->query()); // Preserve search parameter in pagination links

        return view('admin.data_user', compact('users', 'ticketData', 'search'));
    }
    public function deleteTicket($id)
    {
        try {
            // cari record dari ticket
            $ticket = DB::table('ticket')->where('id', $id)->first();
            
            if (!$ticket) {
                return redirect()->route('admin.data.user')
                    ->with('error', 'Data ticket tidak ditemukan.');
            }

            // Delete record dari ticket
            DB::table('ticket')->where('id', $id)->delete();

            return redirect()->route('admin.data.user')
                ->with('success', 'Data ticket berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.data.user')
                ->with('error', 'Gagal menghapus data ticket. Silakan coba lagi.');
        }
    }
}