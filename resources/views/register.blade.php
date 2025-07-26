{{-- register.blade.php --}}
@extends('layout')

{{-- Override title --}}
@section('title', 'Register')

@section('content')
    <div class="px-4 py-auto sm:px-0">
        <!-- Main Content -->
        <main class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <div
                        class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-600 dark:bg-blue-500">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                        Buat akun baru
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                        atau
                        <a href="{{ route('login') }}"
                            class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                            log in ke akun anda
                        </a>
                    </p>
                </div>

                <!-- Register Form -->
                <div
                    class="bg-white dark:bg-gray-800 py-8 px-4 shadow-lg rounded-lg sm:px-10 transition-colors duration-300">
                    <form class="space-y-6" action="{{ route('register') }}" method="POST">
                        @csrf

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Username
                            </label>
                            <div class="mt-1">
                                @php
                                    $usernameClasses =
                                        'appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300';
                                    $usernameClasses .= $errors->has('username')
                                        ? ' border-red-300 dark:border-red-600'
                                        : ' border-gray-300 dark:border-gray-600';
                                @endphp
                                <input id="username" name="username" type="text" autocomplete="username" required
                                    value="{{ old('username') }}" class="{{ $usernameClasses }}"
                                    placeholder="Masukkan Username Anda"
                                    @if ($errors->has('username')) data-has-error="true" @endif>
                            </div>
                            @error('username')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email
                            </label>
                            <div class="mt-1">
                                @php
                                    $emailClasses =
                                        'appearance-none block w-full px-3 py-2 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300';
                                    $emailClasses .= $errors->has('email')
                                        ? ' border-red-300 dark:border-red-600'
                                        : ' border-gray-300 dark:border-gray-600';
                                @endphp
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    value="{{ old('email') }}" class="{{ $emailClasses }}" placeholder="Masukkan Email Anda"
                                    @if ($errors->has('email')) data-has-error="true" @endif>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Buat email baru yang tidak terkait dengan Google ataupun semacamnya.
                            </p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
                            </label>
                            <div class="mt-1 relative">
                                @php
                                    $passwordClasses =
                                        'appearance-none block w-full px-3 py-2 pr-10 border rounded-md placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-colors duration-300';
                                    $passwordClasses .= $errors->has('password')
                                        ? ' border-red-300 dark:border-red-600'
                                        : ' border-gray-300 dark:border-gray-600';
                                @endphp
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                    class="{{ $passwordClasses }}" placeholder="Masukkan Password Anda"
                                    @if ($errors->has('password')) data-has-error="true" @endif>

                                <!-- Toggle Password Visibility Button -->
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePassword"
                                        class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition-colors duration-200">
                                        <!-- Eye Icon (Show Password) -->
                                        <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <!-- Eye Slash Icon (Hide Password) -->
                                        <svg id="eyeSlashIcon" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Password minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.
                            </p>
                        </div>

                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                Create Account
                            </button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <div class="relative">
                        </div>
                    </div>
                </div>


                <!-- Additional Links -->
                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                            Log in di sini
                        </a>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus on first input field with error
            const firstErrorInput = document.querySelector('input[data-has-error="true"]');
            if (firstErrorInput) {
                firstErrorInput.focus();

                // Optional: scroll the error input into view if it's not visible
                firstErrorInput.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Optional: select all text in the input for easy replacement
                firstErrorInput.select();
            }

            // Password visibility toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (togglePassword && passwordInput && eyeIcon && eyeSlashIcon) {
                togglePassword.addEventListener('click', function() {
                    // Toggle password visibility
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icons
                    eyeIcon.classList.toggle('hidden');
                    eyeSlashIcon.classList.toggle('hidden');
                });
            }

            // Additional enhancement: Add subtle animation to error fields
            const errorInputs = document.querySelectorAll('input[data-has-error="true"]');
            errorInputs.forEach(function(input) {
                // Add a subtle shake animation
                input.style.animation = 'shake 0.5s ease-in-out';

                // Remove animation after it completes
                setTimeout(function() {
                    input.style.animation = '';
                }, 500);
            });
        });

        // CSS animation for shake effect (add this to your CSS file or in a <style> tag)
        const style = document.createElement('style');
        style.textContent = `
    @keyframes shake {
        0%, 20%, 40%, 60%, 80% {
            transform: translateX(0);
        }
        10%, 30%, 50%, 70%, 90% {
            transform: translateX(-2px);
        }
    }
`;
        document.head.appendChild(style);
    </script>
@endsection
