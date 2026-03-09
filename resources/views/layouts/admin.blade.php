<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Admin · La 501</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_501_trasparente.png') }}?v=2">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            transition: background-color 0.2s, color 0.2s;
        }

        /* ── VARIABLES ── */
        :root {
            --nav-bg:    #FFFFFF;
            --nav-bdr:   #E4E4E7;
            --nav-txt:   #71717A;
            --nav-act:   #18181B;
            --nav-hover: #3F3F46;
            --pill-bg:   #F4F4F5;
            --pill-act:  #FFFFFF;
            --usr-bg:    #F4F4F5;
            --usr-bdr:   #E4E4E7;
            --accent:    #2563EB;  /* azul profesional para admin */
        }
        .dark {
            --nav-bg:    #0F0F0F;
            --nav-bdr:   rgba(255,255,255,0.07);
            --nav-txt:   #71717A;
            --nav-act:   #FAFAFA;
            --nav-hover: #D4D4D8;
            --pill-bg:   #1A1A1A;
            --pill-act:  #262626;
            --usr-bg:    #1A1A1A;
            --usr-bdr:   rgba(255,255,255,0.07);
        }

        /* ── NAV ── */
        .adm-nav {
            position: sticky; top: 0; z-index: 50;
            background: var(--nav-bg);
            border-bottom: 1px solid var(--nav-bdr);
            height: 56px;
            display: flex; align-items: center;
        }
        .adm-nav-inner {
            width: 100%; max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* logo + badge */
        .adm-logo-wrap {
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0; text-decoration: none;
        }
        .adm-logo-wrap img {
            height: 32px; width: auto;
        }
        .adm-admin-badge {
            font-size: 9px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--accent);
            background: rgba(37,99,235,0.08);
            border: 1px solid rgba(37,99,235,0.2);
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* divider */
        .adm-sep {
            width: 1px; height: 28px;
            background: var(--nav-bdr);
            flex-shrink: 0;
        }

        /* pill nav */
        .adm-pill-nav {
            display: flex;
            align-items: center;
            background: var(--pill-bg);
            border: 1px solid var(--nav-bdr);
            border-radius: 8px;
            padding: 3px;
            gap: 2px;
            overflow-x: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
            flex: 1;
            min-width: 0;
        }
        .adm-pill-nav::-webkit-scrollbar { display: none; }

        .adm-nav-link {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px; font-weight: 600;
            letter-spacing: 0.2px;
            white-space: nowrap;
            text-decoration: none;
            color: var(--nav-txt);
            transition: color 0.15s, background 0.15s;
            position: relative;
            flex-shrink: 0;
        }
        .adm-nav-link:hover {
            color: var(--nav-hover);
            background: rgba(0,0,0,0.04);
        }
        .dark .adm-nav-link:hover {
            background: rgba(255,255,255,0.05);
        }
        .adm-nav-link.active {
            background: var(--pill-act);
            color: var(--nav-act);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
        }
        .dark .adm-nav-link.active {
            box-shadow: 0 1px 3px rgba(0,0,0,0.4);
        }

        /* notification dot */
        .adm-notif-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #EAB308;
            display: inline-block;
            flex-shrink: 0;
            animation: adm-pulse 2s ease-in-out infinite;
        }
        @keyframes adm-pulse {
            0%,100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.6; transform: scale(0.85); }
        }

        /* ── RIGHT ACTIONS ── */
        .adm-actions {
            display: flex; align-items: center; gap: 8px;
            flex-shrink: 0; margin-left: auto;
        }

        /* icon buttons */
        .adm-icon-btn {
            width: 32px; height: 32px;
            border-radius: 6px;
            background: transparent;
            border: 1px solid var(--nav-bdr);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--nav-txt);
            transition: background 0.15s, color 0.15s, border-color 0.15s;
        }
        .adm-icon-btn:hover {
            background: var(--pill-bg);
            color: var(--nav-act);
        }

        /* user button */
        .adm-user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 6px;
            background: var(--usr-bg);
            border: 1px solid var(--usr-bdr);
            cursor: pointer;
            transition: border-color 0.15s;
        }
        .adm-user-btn:hover { border-color: var(--accent); }
        .adm-avatar {
            width: 28px; height: 28px; border-radius: 5px;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: #fff;
            letter-spacing: 0.5px; flex-shrink: 0;
        }
        .adm-user-name {
            font-size: 12px; font-weight: 600;
            color: var(--nav-act); line-height: 1;
            white-space: nowrap;
        }
        .adm-user-role {
            font-size: 10px; color: var(--nav-txt);
            text-transform: uppercase; letter-spacing: 0.5px;
            line-height: 1; margin-top: 2px;
        }
        .adm-chevron {
            color: var(--nav-txt);
            transition: transform 0.2s;
        }
        [x-data].open .adm-chevron { transform: rotate(180deg); }

        /* dropdown */
        .adm-dropdown {
            position: absolute; right: 0; top: calc(100% + 6px);
            width: 200px;
            background: var(--nav-bg);
            border: 1px solid var(--nav-bdr);
            border-radius: 8px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            overflow: hidden;
            z-index: 100;
        }
        .dark .adm-dropdown {
            box-shadow: 0 4px 24px rgba(0,0,0,0.5);
        }
        .adm-dd-item {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 14px;
            font-size: 12px; font-weight: 500;
            color: var(--nav-hover);
            text-decoration: none;
            transition: background 0.12s;
            border: none; background: none; width: 100%;
            text-align: left; cursor: pointer;
        }
        .adm-dd-item:hover { background: var(--pill-bg); }
        .adm-dd-sep { height: 1px; background: var(--nav-bdr); }
        .adm-dd-item.danger { color: #EF4444; }
        .adm-dd-item.danger:hover { background: rgba(239,68,68,0.06); }

        /* ── MOBILE NAV ── */
        .adm-mobile-menu {
            display: none;
            flex-direction: column;
            gap: 2px;
            padding: 8px 12px 12px;
            border-top: 1px solid var(--nav-bdr);
            background: var(--nav-bg);
            position: absolute;
            top: 56px;
            left: 0;
            width: 100%;
        }
        .adm-mobile-menu.open { display: flex; }
        .adm-mobile-link {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 12px;
            border-radius: 6px;
            font-size: 13px; font-weight: 500;
            color: var(--nav-txt);
            text-decoration: none;
            transition: background 0.12s, color 0.12s;
        }
        .adm-mobile-link:hover {
            background: var(--pill-bg);
            color: var(--nav-act);
        }
        .adm-mobile-link.active {
            background: rgba(37,99,235,0.08);
            color: var(--accent);
        }

        /* ── MAIN ── */
        .adm-main {
            flex-grow: 1;
            background: #F8F8F8;
            min-height: calc(100vh - 56px);
        }
        .dark .adm-main { background: #0A0A0A; }
        .adm-main-inner {
            max-width: 1600px;
            margin: 0 auto;
            padding: 28px 24px;
        }

        @media (max-width: 1024px) {
            .adm-pill-nav { display: none; }
            .adm-hamburger { display: flex !important; }
        }
        .adm-hamburger { display: none; }
    </style>
</head>

<body class="bg-white dark:bg-[#0A0A0A] text-zinc-900 dark:text-white min-h-screen flex flex-col">

    <nav class="adm-nav" x-data="{ mobileOpen: false, userOpen: false }">
        <div class="adm-nav-inner">

            {{-- Logo --}}
            <a href="{{ route('admin.dashboard') }}" class="adm-logo-wrap">
                @php
                    $logoSetting = \App\Models\Setting::where('key', 'logo')->first();
                    $logoSrc = ($logoSetting && str_starts_with($logoSetting->value, 'logos/'))
                                ? asset('storage/' . $logoSetting->value)
                                : asset('images/logo_501.png');
                @endphp
                <img src="{{ $logoSrc }}" alt="La 501">
                <span class="adm-admin-badge hidden md:inline">Admin</span>
            </a>

            <div class="adm-sep hidden md:block"></div>

            {{-- Links escritorio (pill style) --}}
            <div class="adm-pill-nav">

                <a href="{{ route('admin.dashboard') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Ventas
                </a>

                <a href="{{ route('admin.menu') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                    Menú
                </a>

                <a href="{{ route('admin.inventory.index') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
                    Inventario
                </a>

                <a href="{{ route('admin.promotions.index') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.promotions.index') ? 'active' : '' }}">
                    Promociones
                </a>

                <a href="{{ route('admin.news') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.news') ? 'active' : '' }}">
                    Novedades
                </a>

                <a href="{{ route('admin.reservations.index') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.reservations.index') ? 'active' : '' }}">
                    <span class="adm-notif-dot"></span>
                    Reservaciones
                </a>

                <a href="{{ route('admin.mensajes') }}"
                    class="adm-nav-link {{ request()->routeIs('admin.mensajes') ? 'active' : '' }}">
                    Mensajes
                </a>

                <a href="{{ route('admin.settings.index') }}"
                   class="adm-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    Información
                </a>

            </div>

            {{-- Acciones derecha --}}
            <div class="adm-actions">

                {{-- Theme --}}
                <button id="theme-toggle" class="adm-icon-btn" title="Cambiar tema">
                    <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                    </svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                </button>

                {{-- User menu --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="adm-user-btn">
                        <div class="adm-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                        <div class="hidden sm:block text-left">
                            <div class="adm-user-name">{{ Auth::user()->name }}</div>
                            <div class="adm-user-role">{{ Auth::user()->role === 'admin' ? 'Admin' : 'Staff' }}</div>
                        </div>
                        <svg class="adm-chevron w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="adm-dropdown" style="display:none;">

                        <a href="{{ route('perfil') }}" class="adm-dd-item">
                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mi Cuenta
                        </a>

                        @if(Auth::id() === 2)
                        <a href="{{ route('admin.users.index') }}" class="adm-dd-item">
                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Gestionar Personal
                        </a>
                        @endif

                        <div class="adm-dd-sep"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="adm-dd-item danger">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>

                    </div>
                </div>

                {{-- Hamburger --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="adm-icon-btn adm-hamburger lg:hidden"
                        x-bind:class="mobileOpen ? 'bg-zinc-100 dark:bg-zinc-800' : ''">
                    <svg x-show="!mobileOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile menu --}}
        <div :class="mobileOpen ? 'open' : ''" class="adm-mobile-menu lg:hidden">
            <a href="{{ route('admin.dashboard') }}"       class="adm-mobile-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Ventas</a>
            <a href="{{ route('admin.menu') }}"             class="adm-mobile-link {{ request()->routeIs('admin.menu') ? 'active' : '' }}">Menú</a>
            <a href="{{ route('admin.inventory.index') }}"  class="adm-mobile-link {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">Inventario</a>
            <a href="{{ route('admin.promotions.index') }}" class="adm-mobile-link {{ request()->routeIs('admin.promotions.index') ? 'active' : '' }}">Promociones</a>
            <a href="{{ route('admin.news') }}"             class="adm-mobile-link {{ request()->routeIs('admin.news') ? 'active' : '' }}">Novedades</a>
            <a href="{{ route('admin.reservations.index') }}" class="adm-mobile-link {{ request()->routeIs('admin.reservations.index') ? 'active' : '' }}">
                <span class="adm-notif-dot"></span> Reservaciones
            </a>
            <a href="{{ route('admin.mensajes') }}" class="adm-mobile-link {{ request()->routeIs('admin.mensajes') ? 'active' : '' }}">Mensajes</a>
            <a href="{{ route('admin.settings.index') }}"  class="adm-mobile-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Información</a>
        </div>
    </nav>

    <main class="adm-main">
        <div class="adm-main-inner">
            @yield('content')
        </div>
    </main>

    <script>
        /* theme toggle */
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
    </script>
</body>
</html>