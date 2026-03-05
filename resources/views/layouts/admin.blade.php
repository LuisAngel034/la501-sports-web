<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Admin - La 501</title>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#0a0a0a',
                        cardBg: '#1a1612',
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .smooth-theme-change,
        .smooth-theme-change *,
        .smooth-theme-change *::before,
        .smooth-theme-change *::after {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        
        .logo-zoom { transition: transform 0.3s ease; }
        .logo-zoom:hover { transform: scale(1.2); }
    </style>
</head>

<body class="smooth-theme-change bg-white text-zinc-900 dark:bg-[#0a0a0a] dark:text-white min-h-screen flex flex-col">

    <nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-white/90 dark:bg-black/90 backdrop-blur-md border-b border-zinc-200 dark:border-white/5">
        
        <div class="flex justify-between items-center p-6">
            
            <div class="flex items-center gap-4">
                <a href="/admin/dashboard" class="flex items-center gap-3">
                    @php
                        $logoSetting = \App\Models\Setting::where('key', 'logo')->first();
                        $logoSrc = ($logoSetting && str_starts_with($logoSetting->value, 'logos/')) 
                                    ? asset('storage/' . $logoSetting->value) 
                                    : asset('images/logo_501.png');
                    @endphp
                    <img src="{{ $logoSrc }}" alt="Logo La 501" class="h-14 w-auto logo-zoom">
                    <span class="hidden md:block bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[10px] font-bold px-2 py-1 rounded uppercase border border-blue-500/20">Admin</span>
                </a>
            </div>

                        <div class="hidden lg:flex p-1 bg-zinc-100 dark:bg-zinc-900/50 rounded-2xl border border-zinc-200 dark:border-white/5 mx-4 overflow-x-auto custom-scrollbar">
                
                <a href="{{ route('admin.dashboard') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Ventas
                </a>

                <a href="{{ route('admin.menu') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.menu') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Menú
                </a>

                {{-- NUEVO: Inventario --}}
                <a href="{{ route('admin.inventory.index') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.inventory.index') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Inventario
                </a>

                {{-- NUEVO: Finanzas 
                <a href="{{ route('admin.finances.index') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.finances.index') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Finanzas
                </a>--}}

                <a href="{{ route('admin.promotions.index') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.promotions.index') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Promociones
                </a>

                <a href="{{ route('admin.news') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.news') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Novedades
                </a>

                <a href="{{ route('admin.reservations.index') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap relative {{ request()->routeIs('admin.reservations.index') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Reservaciones
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                </span>
                </a>
                
                <a href="{{ route('admin.settings.index') }}" 
                class="py-2 px-5 text-xs font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('admin.settings.*') ? 'bg-white dark:bg-[#1a1612] text-zinc-900 dark:text-white shadow-sm border border-zinc-200 dark:border-white/10' : 'text-zinc-500 hover:text-zinc-900 dark:hover:text-white' }}">
                Información
                </a>
            </div>

            <div class="flex items-center gap-4">
                
                <button id="theme-toggle" class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:ring-2 hover:ring-blue-500 transition-all z-50">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                    </svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-zinc-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1 pr-3 rounded-full bg-zinc-100 dark:bg-zinc-800 hover:ring-2 hover:ring-blue-500 transition-all border border-zinc-200 dark:border-white/5">
                        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-xs font-bold leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-zinc-500 uppercase tracking-tighter">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Cliente' }}</p>
                        </div>
                    </button>

                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-56 bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden" style="display: none;">
                        <div class="py-1">
                            <a href="{{ route('perfil') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/5 transition">
                                👤 Mi Cuenta
                            </a>

                            @if(Auth::id() === 2)
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/5 transition border-t border-zinc-200 dark:border-white/5">
                                    👥 Gestionar Personal
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="border-t border-zinc-200 dark:border-white/5">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition font-bold">
                                    🚪 Salir del Sistema
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- MENÚ HAMBURGUESA --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:ring-2 hover:ring-blue-500 transition-all border border-zinc-200 dark:border-white/10">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        {{-- LISTA VERTICAL --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden px-6 pb-6 border-t border-zinc-200 dark:border-white/5 pt-4" style="display: none;">
            <ul class="flex flex-col gap-4 text-center font-bold">
                <li><a href="{{ route('admin.dashboard') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Ventas</a></li>
                <li><a href="{{ route('admin.menu') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Menú</a></li>
                <li><a href="{{ route('admin.inventory.index') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Inventario</a></li>
                <li><a href="{{ route('admin.reservations.index') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Reservaciones</a></li>
                <li><a href="{{ route('admin.finances.index') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Finanzas</a></li>
                <li><a href="{{ route('admin.promotions.index') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Promociones</a></li>
                <li><a href="{{ route('admin.news') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Novedades</a></li>
                <li><a href="{{ route('admin.settings.index') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-blue-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">⚙️ Configuración</a></li>
            </ul>
        </div>
    </nav>

    <main class="flex-grow p-4 md:p-8">
        @yield('content')
    </main>

    <script>
        document.body.classList.remove('smooth-theme-change');
        setTimeout(() => {
            document.body.classList.add('smooth-theme-change');
        }, 100);

        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const html = document.documentElement;

        if (localStorage.getItem('theme') !== 'dark') {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
        }

        function updateIcons() {
            if (html.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        }

        updateIcons();

        themeToggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
            updateIcons();
        });
    </script>
</body>
</html>