<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La 501 Sports</title>
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
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="smooth-theme-change bg-white text-zinc-900 dark:bg-[#0f0d0a] dark:text-white min-h-screen flex flex-col">

    <nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-white/80 dark:bg-black/80 backdrop-blur-md border-b border-zinc-200 dark:border-white/5">
        
        <div class="flex justify-between items-center p-6">
            
            <div class="flex items-center gap-2">
                <a href="/">
                    @php
                        $logoSetting = \App\Models\Setting::where('key', 'logo')->first();
                        $logoSrc = ($logoSetting && str_starts_with($logoSetting->value, 'logos/')) 
                                    ? asset('storage/' . $logoSetting->value) 
                                    : asset('images/logo_501.png');
                    @endphp
                    <img src="{{ $logoSrc }}" alt="Logo La 501" class="h-14 w-auto logo-zoom">
                </a>
            </div>
            
            {{-- MENÚ DE ESCRITORIO (PC/TV) - Todos en horizontal --}}
            <ul class="hidden lg:flex gap-6 text-sm font-medium items-center">
                <li><a href="{{ route('pedido') }}" class="{{ request()->routeIs('pedido') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">A Domicilio</a></li>
                <li><a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">Quienes Somos</a></li>
                <li><a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">Contacto</a></li>
                <li><a href="{{ route('reservaciones') }}" class="{{ request()->routeIs('reservaciones') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">Reservaciones</a></li>
                <li><a href="{{ route('promociones') }}" class="{{ request()->routeIs('promociones') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">Promociones</a></li>
                <li><a href="{{ route('novedades') }}" class="{{ request()->routeIs('novedades') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">Novedades</a></li>
                <li><a href="{{ route('ubicacion') }}" class="{{ request()->routeIs('ubicacion') ? 'text-green-500 border-b-2 border-green-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-green-500' }} transition pb-1">Ubicación</a></li>
            </ul>
            
            <div class="flex gap-4 items-center">
                
                <button id="theme-toggle" class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:ring-2 hover:ring-green-500 transition-all z-50">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20 shadow-sm"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-zinc-600" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                @auth
                    <div class="relative inline-block text-left" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1 pr-3 rounded-full bg-zinc-100 dark:bg-zinc-800 hover:ring-2 hover:ring-green-500 transition-all">
                            <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-black font-bold uppercase text-xs">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-xs font-bold leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-zinc-500">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Cliente' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-56 origin-top-right bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden" style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-zinc-100 dark:border-white/5">
                                <p class="text-xs text-zinc-500 italic">Puntos La 501</p>
                                <p class="text-lg font-bold text-green-500">🏆 {{ Auth::user()->points ?? 0 }} pts</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('perfil') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/5 transition">
                                    👤 Mi Perfil
                                </a>
                                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/5 transition">
                                    ⚙️ Configuración
                                </a>
                            </div>

                            <div class="border-t border-zinc-100 dark:border-white/5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition font-bold">
                                        🚪 Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex text-sm text-zinc-600 dark:text-zinc-300 hover:text-green-500 transition items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Iniciar Sesion</span>
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="relative bg-zinc-100 dark:bg-zinc-800 p-2.5 rounded-xl cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:scale-105 transition-all flex items-center justify-center group">
                    <span class="text-xl">🛒</span>
                    @if(count((array) session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-extrabold px-1.5 py-0.5 rounded-full border-2 border-white dark:border-black animate-bounce group-hover:animate-none">
                            {{ count((array) session('cart')) }}
                        </span>
                    @endif
                </a>

                {{-- MENÚ DE MÓVILES (Botón de las 3 rayitas) --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:ring-2 hover:ring-green-500 transition-all">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        {{-- LISTA VERTICAL PARA MÓVILES --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden px-6 pb-6 border-t border-zinc-200 dark:border-zinc-800 pt-4" style="display: none;">
            <ul class="flex flex-col gap-4 text-center font-bold">
                <li><a href="{{ route('pedido') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">A Domicilio</a></li>
                <li><a href="{{ route('menu') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Menú</a></li>
                <li><a href="{{ route('nosotros') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Quienes Somos</a></li>
                <li><a href="{{ route('contacto') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Contacto</a></li>
                <li><a href="{{ route('reservaciones') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Reservaciones</a></li>
                <li><a href="{{ route('promociones') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Promociones</a></li>
                <li><a href="{{ route('novedades') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Novedades</a></li>
                <li><a href="{{ route('ubicacion') }}" class="block text-zinc-600 dark:text-zinc-300 hover:text-green-500 p-2 bg-zinc-50 dark:bg-white/5 rounded-xl">Ubicación</a></li>
                
                @guest
                    <li class="mt-2">
                        <a href="{{ route('login') }}" class="block bg-green-600 text-black px-6 py-3 rounded-xl shadow-lg hover:bg-green-500">
                            Iniciar Sesión
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="p-10 border-t border-zinc-200 dark:border-zinc-800 text-zinc-500 text-sm flex flex-col md:flex-row justify-between items-center gap-6 bg-white dark:bg-[#0f0d0a] text-center md:text-left">
        <div>
            <p class="text-zinc-900 dark:text-white font-bold">Restaurant La 501 Sports</p>
            <p>Donde el deporte y la familia se unen</p>
        </div>
        <div class="flex gap-4">
            <a href="#" class="hover:text-green-500 transition">Políticas y Términos</a>
        </div>
        <p>© {{ date('Y') }} La 501 Sports. Todos los derechos reservados.</p>
    </footer>

    {{-- SCRIPT ACTUALIZADO --}}
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
            updateIcons();
            
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });

        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</body>
</html>