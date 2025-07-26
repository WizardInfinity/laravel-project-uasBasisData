<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],
            'password' => [
                'required',
                'string'
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        try {
            // Mencoba mengautentikasi user
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Autentikasi success
                $request->session()->regenerate();

                // Redirect to intended page or home
                return redirect()->intended(route('home'))->with('success', 'Login berhasil! Selamat datang.');
            }

            // Autentikasi gagal
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang dimasukkan salah.',
            ]);

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput($request->except('password'));
        } catch (\Exception $e) {
            return back()
                ->withInput($request->except('password'))
                ->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}