<!-- resources/views/navbar.blade.php -->
<nav class="sticky top-0 z-50 bg-blue-600 dark:bg-blue-800 shadow-lg transition-colors duration-300"
    x-data="{
        open: false,
        darkMode: false,
        init() {
            this.darkMode = localStorage.getItem('darkMode') === 'true' || false;
            this.updateDarkMode();
        },
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            this.updateDarkMode();
            localStorage.setItem('darkMode', this.darkMode);
        },
        updateDarkMode() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <img class="h-40 w-40 mb-3" src="{{ url('SyntaxError404 (6).png') }}" alt="Logo">
                </div>
            </div>
            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-4">
                    <a href="{{ route('home') }}"
                        class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-blue-700' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('movie') }}"
                        class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('movie') ? 'bg-blue-700' : '' }}">
                        Movie
                    </a>

                    {{-- Tampilkan History menu hanya untuk user yang diautentikasi --}}
                    @auth
                        <a href="{{ route('purchase.history') }}"
                            class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('purchase.history') ? 'bg-blue-700' : '' }}">
                            History
                        </a>
                    @endauth

                    {{-- Tampilkan Admin menu hanya jika yang login dengan username ADMIN --}}
                    @auth
                        @if (auth()->check() && auth()->user()->getAttribute('username') === 'ADMIN')
                            <a href="{{ route('admin.movie.create') }}"
                                class="text-amber-400 hover:bg-amber-600 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.movie.create') ? 'bg-amber-600 text-white' : '' }}">
                                Create
                            </a>
                        @endif
                    @endauth

                    {{-- Tampilkan Data User hanya jika yang login dengan username ADMIN --}}
                    @auth
                        @if (auth()->check() && auth()->user()->getAttribute('username') === 'ADMIN')
                            <a href="{{ route('admin.data.user') }}"
                                class="text-amber-400 hover:bg-amber-600 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.data.user') ? 'bg-amber-600 text-white' : '' }}">
                                Data User
                            </a>
                        @endif
                    @endauth

                    {{-- Tampilkan tombol login --}}
                    @guest
                        <a href="{{ route('login') }}"
                            class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('login') ? 'bg-blue-700' : '' }}">
                            Login
                        </a>
                    @endguest

                    {{-- Tampilkan tombol logout --}}
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                Logout
                            </button>
                        </form>
                    @endauth

                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode()"
                        class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open"
                    class="text-white hover:bg-blue-700 p-2 rounded-md transition-colors duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-blue-700 dark:bg-blue-900">
            <a href="{{ route('home') }}"
                class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-blue-800' : '' }}">
                Home
            </a>
            <a href="{{ route('movie') }}"
                class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('movie') ? 'bg-blue-800' : '' }}">
                Movie
            </a>

            {{-- Tampilkan History menu hanya untuk user yang diautentikasi (Mobile) --}}
            @auth
                <a href="{{ route('purchase.history') }}"
                    class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('purchase.history') ? 'bg-blue-800' : '' }}">
                    History
                </a>
            @endauth

            {{-- Tampilkan Create menu hanya jika yang login dengan username ADMIN (Mobile) --}}
            @if (auth()->check() && auth()->user()->getAttribute('username') === 'ADMIN')
                <a href="{{ route('admin.movie.create') }}"
                    class="text-amber-400 hover:bg-amber-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('admin.movie.create') ? 'bg-amber-600 text-white' : '' }}">
                    Create
                </a>
            @endif

            {{-- Show Data User menu hanya jika yang login dengan username ADMIN --}}
            @auth
                @if (auth()->check() && auth()->user()->getAttribute('username') === 'ADMIN')
                    <a href="{{ route('admin.data.user') }}"
                        class="text-amber-400 hover:bg-amber-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('admin.data.user') ? 'bg-amber-600 text-white' : '' }}">
                        Data User
                    </a>
                @endif
            @endauth

            {{-- LOGIN mobile --}}
            @guest
                <a href="{{ route('login') }}"
                    class="text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('login') ? 'bg-blue-800' : '' }}">
                    Login
                </a>
            @endguest

            {{-- LOGOUT mobile --}}
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left text-white hover:bg-blue-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                        Logout
                    </button>
                </form>
            @endauth

            <!-- Mobile Dark Mode Toggle -->
            <button @click="toggleDarkMode()"
                class="text-white hover:bg-blue-800 w-full text-left px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 flex items-center">
                <svg x-show="!darkMode" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg x-show="darkMode" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343
                        17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
            </button>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    });
</script>