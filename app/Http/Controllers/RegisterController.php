<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    
    public function showRegistrationForm()
    {
        return view('register');
    }

    
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
                'alpha_dash' // hanya boleh huruf, angka, dash, dan underscore
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'username.required'      => 'Username wajib diisi.',
            'username.unique'        => 'Username sudah digunakan.',
            'username.alpha_dash'    => 'Username hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        try {
            // Membuat user baru 
            $user = User::create([
                'username' => $request->input('username'),
                'email'    => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')
                            ->with('success', 'Akun berhasil dibuat! Silakan login.');

        } catch (\Exception $e) {
            return back()
                ->withInput($request->except('password'))
                ->with('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.');
        }
    }
}
