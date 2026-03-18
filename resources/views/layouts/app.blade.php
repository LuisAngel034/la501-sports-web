<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La 501 Sports</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_501_trasparente.png') }}?v=2">

    {{-- Tema antes de pintar --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{-- Tailwind --}}
    <script>
        tailwind = { config: { darkMode: 'class' } }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Fuentes de marca --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── TOKENS ── */
        :root {
            --or:   #F97316;
            --or2:  #EA580C;
            --gn:   #16A34A;
            --gn2:  #22C55E;
        }

        /* ── TRANSICIÓN SUAVE DE TEMA ── */
        .theme-ready,
        .theme-ready *,
        .theme-ready *::before,
        .theme-ready *::after {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 280ms;
        }

        /* ── LOGO ── */
        .nav-logo-img {
            transition: transform 0.3s ease, filter 0.3s ease;
        }
        .nav-logo-img:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(249,115,22,0.5));
        }

        /* ── NAV LINK UNDERLINE DESLIZANTE ── */
        .nav-link {
            position: relative;
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding-bottom: 4px;
            transition: color 0.2s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 2px;
            background: var(--or);
            transition: width 0.25s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }

        /* ── BOTÓN CTA NAV ── */
        .nav-cta-btn {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
            background: var(--or);
            padding: 8px 20px;
            clip-path: polygon(8px 0%, 100% 0%, calc(100% - 8px) 100%, 0% 100%);
            box-shadow: 0 3px 18px rgba(249,115,22,0.4);
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .nav-cta-btn:hover {
            background: var(--or2);
            box-shadow: 0 5px 26px rgba(249,115,22,0.55);
            transform: translateY(-1px);
        }

        /* ── THEME TOGGLE ── */
        .theme-toggle-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; border: none; outline: none;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .theme-toggle-btn:hover {
            box-shadow: 0 0 0 2px var(--or);
            transform: scale(1.05);
        }

        /* ── CARRITO ── */
        .cart-link {
            position: relative;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            width: 38px; height: 38px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .cart-link:hover {
            box-shadow: 0 0 0 2px var(--or);
            transform: scale(1.05);
        }

        /* ── DROPDOWN USUARIO ── */
        .user-dropdown {
            border-top: 2px solid var(--or) !important;
        }
        .user-avatar {
            background: linear-gradient(135deg, var(--or), var(--or2)) !important;
        }

        /* ── MOBILE LINK ── */
        .mobile-nav-link {
            font-family: 'Oswald', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
            padding: 11px 16px;
            border-radius: 10px;
            border-left: 3px solid transparent;
            transition: color 0.2s, border-color 0.2s, background 0.2s;
        }
        .mobile-nav-link:hover {
            border-left-color: var(--or);
        }

        /* ── FOOTER ── */
        .footer-brand-name {
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .footer-or-bar {
            display: inline-block;
            width: 32px; height: 2px;
            background: linear-gradient(to right, var(--or), var(--gn));
            border-radius: 2px;
            margin-bottom: 8px;
        }
        .footer-link {
            font-family: 'Oswald', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-link:hover { color: var(--or) !important; }

        /* ── BORDE INFERIOR NAV ── */
        .nav-bottom-border {
            border-bottom: 1px solid rgba(249,115,22,0.15);
        }
        .dark .nav-bottom-border {
            border-bottom: 1px solid rgba(249,115,22,0.12);
        }
    </style>
</head>

<body class="theme-ready bg-white text-zinc-900 dark:bg-[#0f0d0a] dark:text-white min-h-screen flex flex-col">

    {{-- ══════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════ --}}
    <nav x-data="{ mobileMenuOpen: false }"
         class="sticky top-0 z-50 bg-white/90 dark:bg-black/85 backdrop-blur-md nav-bottom-border">

        <div class="relative flex items-center justify-between px-6 py-4 w-full">

            {{-- Logo --}}
            <a href="/" class="flex-shrink-0 z-10">
                @php
                    $logoSetting = \App\Models\Setting::where('key', 'logo')->first();
                    $logoSrc = ($logoSetting && str_starts_with($logoSetting->value, 'logos/'))
                                ? asset('storage/' . $logoSetting->value)
                                : asset('images/logo_501.png');
                @endphp
                <img src="{{ $logoSrc }}" alt="Logo La 501" class="h-14 w-auto nav-logo-img">
            </a>

            {{-- Links Escritorio --}}
            <ul class="hidden lg:flex gap-1 items-center absolute left-1/2 -translate-x-1/2">
                <li><a href="{{ route('nosotros') }}" class="nav-link px-3 {{ request()->routeIs('nosotros') ? 'active text-orange-500' : 'text-zinc-500 dark:text-zinc-400 hover:text-orange-500' }}">Quienes Somos</a></li>
                <li><a href="{{ route('contacto') }}" class="nav-link px-3 {{ request()->routeIs('contacto') ? 'active text-orange-500' : 'text-zinc-500 dark:text-zinc-400 hover:text-orange-500' }}">Contacto</a></li>
                <li><a href="{{ route('reservaciones') }}" class="nav-link px-3 {{ request()->routeIs('reservaciones') ? 'active text-orange-500' : 'text-zinc-500 dark:text-zinc-400 hover:text-orange-500' }}">Reservaciones</a></li>
                <li><a href="{{ route('promociones') }}" class="nav-link px-3 {{ request()->routeIs('promociones') ? 'active text-orange-500' : 'text-zinc-500 dark:text-zinc-400 hover:text-orange-500' }}">Promociones</a></li>
                <li><a href="{{ route('novedades') }}" class="nav-link px-3 {{ request()->routeIs('novedades') ? 'active text-orange-500' : 'text-zinc-500 dark:text-zinc-400 hover:text-orange-500' }}">Novedades</a></li>
                <li><a href="{{ route('ubicacion') }}" class="nav-link px-3 {{ request()->routeIs('ubicacion') ? 'active text-orange-500' : 'text-zinc-500 dark:text-zinc-400 hover:text-orange-500' }}">Ubicación</a></li>
            </ul>

            {{-- Acciones --}}
            <div class="flex gap-3 items-center flex-shrink-0 z-10">

                <a href="{{ route('pedido') }}" class="hidden lg:inline-flex nav-cta-btn">
                    🛵 Pedir Ahora
                </a>

                {{-- Theme toggle --}}
                <button id="theme-toggle" class="theme-toggle-btn bg-zinc-100 dark:bg-zinc-800">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-zinc-500" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                </button>

                {{-- Usuario autenticado --}}
                @auth
                    <div class="relative inline-block text-left" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 p-1 pr-3 rounded-full bg-zinc-100 dark:bg-zinc-800 hover:ring-2 hover:ring-orange-500 transition-all">
                            <div class="user-avatar h-8 w-8 rounded-full flex items-center justify-center text-white font-bold uppercase text-xs shadow">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-xs font-bold leading-none text-zinc-800 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-zinc-500 uppercase">{{ Auth::user()->role }}</p>
                            </div>
                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="user-dropdown absolute right-0 mt-2 w-56 origin-top-right bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden"
                             style="display:none;">

                            <div class="px-4 py-3 border-b border-zinc-100 dark:border-white/5">
                                <p class="text-xs text-zinc-500 italic">Puntos La 501</p>
                                <p class="text-lg font-bold text-orange-500">🏆 {{ Auth::user()->points ?? 0 }} pts</p>
                            </div>
                            
                            <div class="py-1">
                                {{-- 🌟 ACCESO INTELIGENTE A PANEL ADMINISTRATIVO --}}
                                @if(in_array(auth()->user()->role, ['admin', 'mesero', 'empleado']))
    @php
        // Si es admin va a su dashboard, TODOS los demás (mesero/empleado) van a mesas
        $panelRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('mesero.mesas');
    @endphp
    <a href="{{ $panelRoute }}" class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-orange-600 dark:text-orange-500 hover:bg-orange-50 dark:hover:bg-orange-500/10 transition">
        💼 Panel de Empleado
    </a>
@endif

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
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 hover:text-orange-500 transition font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Iniciar Sesión</span>
                    </a>
                @endauth

                {{-- Carrito --}}
                <a href="{{ route('cart.index') }}" class="cart-link bg-zinc-100 dark:bg-zinc-800">
                    <span class="text-xl">🛒</span>
                    @if(count((array) session('cart')) > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-extrabold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white dark:border-[#0f0d0a] animate-bounce">
                            {{ count((array) session('cart')) }}
                        </span>
                    @endif
                </a>

                {{-- Hamburguesa --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden w-9 h-9 flex items-center justify-center rounded-10 bg-zinc-100 dark:bg-zinc-800 border border-transparent hover:border-orange-500 transition-all">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5 text-zinc-600 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" class="w-5 h-5 text-zinc-600 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

            </div>
        </div>

        {{-- Menú móvil --}}
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden px-5 pb-5 border-t border-orange-500/10 dark:border-orange-500/10"
             style="display:none;">
            <div class="flex flex-col gap-2 pt-4">
                
                {{-- 🌟 ACCESO INTELIGENTE MÓVIL --}}
                {{-- 🌟 ACCESO INTELIGENTE MÓVIL --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'mesero', 'empleado']))
                        @php
                            // Simplificado: Admin va a su dashboard, el resto a mesas
                            $panelRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('mesero.mesas');
                        @endphp
                        <a href="{{ $panelRoute }}" class="mobile-nav-link text-white bg-orange-600 hover:bg-orange-700 shadow-md mb-2">
                            💼 Ir a Panel de Empleado
                        </a>
                    @endif
                @endauth

                <a href="{{ route('pedido') }}"       class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">A Domicilio</a>
                <a href="{{ route('menu') }}"         class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Menú</a>
                <a href="{{ route('nosotros') }}"     class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Quienes Somos</a>
                <a href="{{ route('contacto') }}"     class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Contacto</a>
                <a href="{{ route('reservaciones') }}" class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Reservaciones</a>
                <a href="{{ route('promociones') }}"  class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Promociones</a>
                <a href="{{ route('novedades') }}"    class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Novedades</a>
                <a href="{{ route('ubicacion') }}"    class="mobile-nav-link text-zinc-600 dark:text-zinc-300 hover:text-orange-500 dark:hover:text-orange-400 bg-zinc-50 dark:bg-white/5">Ubicación</a>

                @guest
                    <a href="{{ route('login') }}" class="mt-2 nav-cta-btn text-center py-3">
                        Iniciar Sesión
                    </a>
                @endguest
            </div>
        </div>

    </nav>

    {{-- ══════════════════════════════════════
         CONTENIDO DE CADA VISTA
    ══════════════════════════════════════ --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ══════════════════════════════════════
         FOOTER
    ══════════════════════════════════════ --}}
    <footer class="border-t border-orange-500/15 dark:border-orange-500/10 bg-white dark:bg-[#0f0d0a]">
        <div class="max-w-screen-xl mx-auto px-8 py-10 flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
            <div>
                <div class="footer-or-bar"></div>
                <p class="footer-brand-name text-zinc-900 dark:text-white">Restaurant La 501 Sports</p>
                <p class="text-xs text-zinc-500 mt-1 tracking-wide">Donde el deporte y la familia se unen</p>
            </div>
            <div class="flex gap-6">
                <a href="#" class="footer-link text-zinc-500 dark:text-zinc-500">Políticas y Términos</a>
                <a href="{{ route('nosotros') }}" class="footer-link text-zinc-500 dark:text-zinc-500">Quienes Somos</a>
                <a href="{{ route('contacto') }}" class="footer-link text-zinc-500 dark:text-zinc-500">Contacto</a>
            </div>
            <p class="text-xs text-zinc-400 dark:text-zinc-600 tracking-wide">
                © {{ date('Y') }} La 501 Sports.<br class="md:hidden"> Todos los derechos reservados.
            </p>
        </div>
    </footer>

    {{-- ══════════════════════════════════════
         SCRIPTS
    ══════════════════════════════════════ --}}
    <script>
        document.body.classList.remove('theme-ready');
        setTimeout(() => document.body.classList.add('theme-ready'), 120);

        const themeBtn  = document.getElementById('theme-toggle');
        const darkIcon  = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const html      = document.documentElement;

        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }

        function syncIcons() {
            if (html.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        }
        syncIcons();

        themeBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
            syncIcons();
        });

        tailwind.config = { darkMode: 'class' };
    </script>
</body>
</html>