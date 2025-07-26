<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        // Dapatkan maksimal 8 movie untuk carousel, diurutkan berdasarkan yang terbaru
        $movies = Movie::inRandomOrder()->limit(8)->get();
        
        return view('home', compact('movies'));
    }

    public function movie(Request $request)
    {
        $query = Movie::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('rating', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('tahun_rilis', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Fungsionalitas penyortiran
        $sortBy = $request->input('sort', 'terbaru'); // default sortir
        
        switch ($sortBy) {
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            case 'tahun_rilis_terbaru':
                $query->orderBy('tahun_rilis', 'desc');
                break;
            case 'tahun_rilis_terlama':
                $query->orderBy('tahun_rilis', 'asc');
                break;
            case 'judul_az':
                $query->orderBy('judul', 'asc');
                break;
            case 'judul_za':
                $query->orderBy('judul', 'desc');
                break;
            case 'rating_tinggi':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_rendah':
                $query->orderBy('rating', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $movies = $query->paginate(8)->withQueryString();
        
        return view('movie', compact('movies'));
    }

    public function movie_detail($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movie_detail', compact('movie'));
    }
}