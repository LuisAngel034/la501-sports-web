@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;600;700&family=Inter:wght@400;500&display=swap');

    /* ══════════════════════════════════════════
       VARIABLES — dark por defecto, light via
       selector html:not(.dark) (Tailwind class mode)
    ══════════════════════════════════════════ */
    .s501-page {
        --orange:      #F97316;
        --orange-dark: #C2410C;
        --green:       #16A34A;
        --green-light: #22C55E;

        /* DARK (default — html.dark o sin clase) */
        --bg:       #0A0A0A;
        --bg-card:  #141414;
        --bg-card2: #1C1C1C;
        --txt:      #FFFFFF;
        --txt-sub:  #A1A1AA;
        --border:   rgba(255,255,255,0.07);
        --glow-o:   rgba(249,115,22,0.22);
        --glow-g:   rgba(22,163,74,0.18);
        --hex: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15L13.99 9.25zM3 17.9v12.7l10.99 6.34 11-6.35V17.9l-11-6.34L3 17.9zM0 15l12.98-7.5V0h-2v6.35L0 12.69V15zm0 18.5L12.98 41v8h-2v-6.85L0 35.81v-2.3zM15 0v7.5L27.99 15H28v-2.31h-.01L17 6.35V0h-2zm0 49v-8l12.99-7.5H28v2.31h-.01L17 42.15V49h-2z'/%3E%3C/g%3E%3C/svg%3E");
    }

    /* ── LIGHT MODE — cuando html NO tiene clase .dark ── */
    html:not(.dark) .s501-page {
        --bg:       #F4F4F5;
        --bg-card:  #FFFFFF;
        --bg-card2: #EBEBEB;
        --txt:      #111111;
        --txt-sub:  #52525B;
        --border:   rgba(0,0,0,0.09);
        --glow-o:   rgba(249,115,22,0.10);
        --glow-g:   rgba(22,163,74,0.09);
        --hex: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23000000' fill-opacity='0.025'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15L13.99 9.25zM3 17.9v12.7l10.99 6.34 11-6.35V17.9l-11-6.34L3 17.9zM0 15l12.98-7.5V0h-2v6.35L0 12.69V15zm0 18.5L12.98 41v8h-2v-6.85L0 35.81v-2.3zM15 0v7.5L27.99 15H28v-2.31h-.01L17 6.35V0h-2zm0 49v-8l12.99-7.5H28v2.31h-.01L17 42.15V49h-2z'/%3E%3C/g%3E%3C/svg%3E");
    }

    /* ─── BASE ─── */
    .s501-page {
        background-color: var(--bg);
        color: var(--txt);
        font-family: 'Inter', sans-serif;
        overflow-x: hidden;
        /* transición suave al cambiar tema */
        transition: background-color .3s, color .3s;
    }

    /* ─── HERO ─── */
    .s501-hero {
        position: relative;
        background-color: var(--bg-card);
        background-image: var(--hex);
        border-bottom: 3px solid var(--orange);
        padding: 80px 40px 70px;
        text-align: center;
        overflow: hidden;
        transition: background-color .3s;
    }
    .s501-hero::before {
        content: '';
        position: absolute;
        top: -100px; left: 50%;
        transform: translateX(-50%);
        width: 700px; height: 350px;
        background: radial-gradient(ellipse, var(--glow-o) 0%, transparent 70%);
        pointer-events: none;
    }
    .s501-hero-badge {
        display: inline-block;
        background: var(--orange);
        color: #fff;
        font-family: 'Oswald', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        padding: 6px 20px;
        clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
        margin-bottom: 24px;
    }
    .s501-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(60px, 12vw, 110px);
        line-height: 0.95;
        letter-spacing: 6px;
        color: var(--txt);
        margin: 0 0 20px;
        position: relative; z-index: 1;
        transition: color .3s;
    }
    .s501-hero h1 span { color: var(--orange); }
    .s501-hero p {
        font-size: 17px;
        color: var(--txt-sub);
        max-width: 580px;
        margin: 0 auto;
        line-height: 1.75;
        position: relative; z-index: 1;
        transition: color .3s;
    }

    /* ─── MAIN SECTION ─── */
    .s501-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 32px;
    }

    /* ─── BANNER ─── */
    .s501-banner {
        position: relative;
        background: var(--bg-card);
        background-image: var(--hex);
        border: 1px solid var(--border);
        border-left: 5px solid var(--orange);
        border-radius: 20px;
        padding: 60px 56px;
        margin-bottom: 80px;
        overflow: hidden;
        transition: background-color .3s, border-color .3s;
    }
    .s501-banner::after {
        content: '';
        position: absolute;
        right: -80px; top: 50%;
        transform: translateY(-50%);
        width: 320px; height: 320px;
        background: radial-gradient(ellipse, var(--glow-g) 0%, transparent 70%);
        pointer-events: none;
    }
    .s501-banner-deco {
        position: absolute;
        right: 32px; top: 50%;
        transform: translateY(-50%);
        font-family: 'Bebas Neue', sans-serif;
        font-size: 220px;
        color: var(--orange);
        opacity: 0.1;
        line-height: 1;
        pointer-events: none;
        z-index: 0;
        user-select: none;
    }
    .s501-banner-inner {
        max-width: 600px;
        position: relative;
        z-index: 1;
    }
    .s501-banner h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(34px, 5vw, 54px);
        letter-spacing: 2px;
        color: var(--txt);
        line-height: 1.1;
        margin: 0 0 20px;
        transition: color .3s;
    }
    .s501-banner h2 em { color: var(--orange); font-style: normal; }
    .s501-banner p {
        color: var(--txt-sub);
        font-size: 16px;
        line-height: 1.8;
        margin: 0;
        transition: color .3s;
    }

    /* ─── DIVIDER ─── */
    .s501-divider {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 40px;
    }
    .s501-divider span {
        font-family: 'Oswald', sans-serif;
        font-size: 12px;
        letter-spacing: 4px;
        color: var(--orange);
        text-transform: uppercase;
        white-space: nowrap;
    }
    .s501-divider::before,
    .s501-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--orange), transparent);
        opacity: 0.35;
    }

    /* ─── VALORES ─── */
    .s501-valores {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        margin-bottom: 80px;
    }
    .s501-card {
        background: var(--bg-card);
        background-image: var(--hex);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 40px 28px;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s, background-color .3s;
        cursor: default;
    }
    .s501-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--glow-o), transparent 60%);
        opacity: 0;
        transition: opacity 0.3s;
        border-radius: 18px;
    }
    /* línea superior naranja que aparece en hover */
    .s501-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--orange), var(--green));
        opacity: 0;
        transition: opacity .3s;
    }
    .s501-card:hover {
        transform: translateY(-7px);
        border-color: var(--orange);
        box-shadow: 0 10px 40px var(--glow-o);
    }
    .s501-card:hover::before { opacity: 1; }
    .s501-card:hover::after  { opacity: 1; }

    .s501-card-icon {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--orange), var(--orange-dark));
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        font-size: 26px;
        box-shadow: 0 4px 20px rgba(249,115,22,0.35);
        transition: transform 0.3s;
        position: relative; z-index: 1;
    }
    .s501-card:hover .s501-card-icon { transform: scale(1.12) rotate(-6deg); }
    .s501-card h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--txt);
        margin: 0 0 10px;
        position: relative; z-index: 1;
        transition: color 0.3s;
    }
    .s501-card:hover h3 { color: var(--orange); }
    .s501-card p {
        font-size: 14px;
        color: var(--txt-sub);
        line-height: 1.65;
        margin: 0;
        position: relative; z-index: 1;
    }

    /* ─── HISTORIA ─── */
    .s501-historia {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: center;
        border-top: 1px solid var(--border);
        padding-top: 80px;
    }
    .s501-historia-label {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }
    .s501-historia-label::before {
        content: '';
        display: block;
        width: 5px; height: 48px;
        background: linear-gradient(to bottom, var(--orange), var(--green-light));
        border-radius: 3px;
        flex-shrink: 0;
    }
    .s501-historia-label h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 48px;
        letter-spacing: 3px;
        color: var(--txt);
        margin: 0;
        line-height: 1;
        transition: color .3s;
    }
    .s501-historia-label h2 span { color: var(--green-light); }
    .s501-historia-text p {
        color: var(--txt-sub);
        font-size: 16px;
        line-height: 1.8;
        margin: 0 0 18px;
        transition: color .3s;
    }

    /* ─── IMAGE ─── */
    .s501-img-wrap {
        position: relative;
        border-radius: 20px;
    }
    .s501-img-glow {
        position: absolute;
        inset: -3px;
        background: linear-gradient(135deg, var(--orange), var(--green));
        border-radius: 21px;
        z-index: 0;
        opacity: 0.65;
        transition: opacity 0.4s;
    }
    .s501-img-wrap:hover .s501-img-glow { opacity: 1; }
    .s501-img-inner {
        position: relative; z-index: 1;
        border-radius: 18px;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        background: var(--bg-card2);
        transition: background-color .3s;
    }
    .s501-img-inner img {
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.85;
        transition: transform 0.6s, opacity 0.4s;
        display: block;
    }
    .s501-img-wrap:hover .s501-img-inner img {
        transform: scale(1.06);
        opacity: 1;
    }
    .s501-img-badge {
        position: absolute;
        bottom: 24px; left: 50%;
        transform: translateX(-50%);
        background: rgba(0,0,0,0.72);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid var(--orange);
        border-radius: 100px;
        padding: 14px 34px;
        text-align: center;
        z-index: 2;
        white-space: nowrap;
        box-shadow: 0 4px 30px rgba(249,115,22,0.25);
    }
    /* En light mode el badge necesita fondo más visible */
    html:not(.dark) .s501-img-badge {
        background: rgba(255,255,255,0.82);
    }
    .s501-img-badge .b-icon  { font-size: 18px; display: block; margin-bottom: 2px; }
    .s501-img-badge .b-years {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 38px;
        color: var(--orange);
        letter-spacing: 3px;
        display: block;
        line-height: 1;
    }
    .s501-img-badge .b-label {
        font-size: 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }
    /* label del badge: blanco en dark, oscuro en light */
    .s501-img-badge .b-label { color: #ccc; }
    html:not(.dark) .s501-img-badge .b-label { color: #52525B; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .s501-historia { grid-template-columns: 1fr; gap: 40px; }
        .s501-banner   { padding: 36px 28px; }
        .s501-banner-deco { display: none; }
        .s501-section  { padding: 48px 20px; }
        .s501-hero     { padding: 60px 24px 50px; }
    }
</style>

<div class="s501-page">

    {{-- CARRUSEL DE IMÁGENES PRINCIPALES --}}
    @php
        $carouselSlides = \App\Models\CarouselSlide::where('is_active', true)->orderBy('order')->get();
        if ($carouselSlides->isEmpty()) {
            $carouselSlides = collect([
                (object)[
                    'image_path' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1200&auto=format&fit=crop',
                    'subtitle' => 'Gourmet & Grill',
                    'title' => 'SABOR INIGUALABLE',
                    'description' => 'Las mejores hamburguesas a la parrilla y cerveza artesanal bien fría.'
                ],
                (object)[
                    'image_path' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop',
                    'subtitle' => 'La emoción del juego',
                    'title' => 'PASIÓN DEPORTIVA',
                    'description' => 'El mejor ambiente familiar para disfrutar de tus deportes favoritos.'
                ],
                (object)[
                    'image_path' => 'https://images.unsplash.com/photo-1608039829572-78524f79c4c7?q=80&w=1200&auto=format&fit=crop',
                    'subtitle' => 'Para picar',
                    'title' => 'MOMENTOS COMPARTIDOS',
                    'description' => 'Deliciosas alitas y snacks perfectos para disfrutar con amigos.'
                ]
            ]);
        }
    @endphp

    <div x-data="{ 
            activeSlide: 0, 
            slides: @js($carouselSlides).map(s => ({ ...s, isWide: true })),
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
            init() {
                this.slides.forEach(slide => {
                    const img = new Image();
                    img.onload = () => {
                        slide.isWide = (img.width / img.height) > 1.25 && img.width >= 1000;
                    };
                    img.src = slide.image_path.startsWith('storage/') ? '/' + slide.image_path : slide.image_path;
                });

                if(this.slides.length > 1) {
                    setInterval(() => this.next(), 6000);
                }
            }
         }" 
         class="relative w-full h-[70vh] md:h-[80vh] overflow-hidden bg-black select-none border-b-2 border-orange-500">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-in-out duration-700 transform"
                 x-transition:enter-start="opacity-0 translate-x-full"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in-out duration-700 transform"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-full"
                 class="absolute inset-0 w-full h-full flex items-center justify-center bg-black">
                <!-- Fondo difuminado para rellenar los bordes en caso de imágenes cuadradas o verticales (solo si no es panorámica) -->
                <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none" x-show="slide.isWide === false" x-cloak>
                    <img :src="slide.image_path.startsWith('storage/') ? '/' + slide.image_path : slide.image_path" class="w-full h-full object-cover blur-2xl scale-110 opacity-45" aria-hidden="true" alt="">
                </div>
                <!-- Imagen con filtro oscuro para legibilidad del texto (solo si hay texto) -->
                <div class="absolute inset-0 bg-black/35 z-10" x-show="(slide.title && slide.title.trim() !== '') || (slide.subtitle && slide.subtitle.trim() !== '') || (slide.description && slide.description.trim() !== '')"></div>
                <!-- Imagen real -->
                <img :src="slide.image_path.startsWith('storage/') ? '/' + slide.image_path : slide.image_path" 
                     class="z-1" 
                     :class="slide.isWide === false ? 'relative max-w-full max-h-full object-contain' : 'absolute inset-0 w-full h-full object-cover'"
                     alt="Banner de carrusel">
                
                <!-- Contenido del Slide (solo si hay textos) -->
                <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-6 z-20" x-show="(slide.title && slide.title.trim() !== '') || (slide.subtitle && slide.subtitle.trim() !== '') || (slide.description && slide.description.trim() !== '')">
                    <span class="inline-block bg-orange-600 text-white font-['Oswald'] text-xs font-bold uppercase tracking-[4px] px-3 py-1.5 rounded-md mb-4 shadow-lg shadow-orange-600/30" x-show="slide.subtitle && slide.subtitle.trim() !== ''" x-text="slide.subtitle"></span>
                    <h2 class="text-white font-['Bebas_Neue'] text-4xl sm:text-6xl md:text-8xl tracking-widest drop-shadow-2xl" x-show="slide.title && slide.title.trim() !== ''" x-text="slide.title"></h2>
                    <p class="text-zinc-200 text-sm sm:text-lg max-w-xl mt-3 font-medium drop-shadow-md" x-show="slide.description && slide.description.trim() !== ''" x-text="slide.description"></p>
                    
                    <!-- Botón de acción rápido -->
                    <a href="{{ route('pedido') }}" class="mt-6 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-['Oswald'] text-xs font-bold uppercase tracking-[2px] rounded-xl shadow-lg shadow-green-600/30 transition transform hover:-translate-y-0.5 active:scale-95">
                        🍽️ VER MENÚ / PEDIR AHORA
                    </a>
                </div>
            </div>
        </template>

        <!-- Botón Izquierdo -->
        <button @click="prev()" type="button" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-full flex items-center justify-center border border-white/10 transition active:scale-90 hover:border-orange-500">
            &larr;
        </button>

        <!-- Botón Derecho -->
        <button @click="next()" type="button" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-full flex items-center justify-center border border-white/10 transition active:scale-90 hover:border-orange-500">
            &rarr;
        </button>

        <!-- Indicadores de Slide -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex gap-2.5">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        type="button" 
                        class="w-8 h-1.5 rounded-full transition-all duration-300"
                        :class="activeSlide === index ? 'bg-orange-500 w-12' : 'bg-white/40 hover:bg-white/60'"></button>
            </template>
        </div>
    </div>

    {{-- HERO --}}
    <div class="s501-hero">
        <div class="s501-hero-badge">La 501 Sports Restaurant alan gome</div>
        <h1>Quienes<br><span>Somos</span></h1>
        <p>Bienvenidos a Restaurant La 501 Sports, donde la pasión por el deporte y la buena comida se unen para crear momentos inolvidables en familia.</p>
    </div>

    <div class="s501-section">

        {{-- BANNER --}}
        <div class="s501-banner">
            <div class="s501-banner-deco">501</div>
            <div class="s501-banner-inner">
                <h2>Más que un restaurante,<br>somos tu <em>segundo hogar</em></h2>
                <p>Desde 20XX, hemos sido el lugar favorito de familias y amigos para disfrutar de los mejores partidos mientras saborean nuestra deliciosa comida. Nuestro ambiente combina la emoción del deporte con la calidez de un hogar.</p>
            </div>
        </div>

        {{-- VALORES --}}
        <div class="s501-divider"><span>Nuestros Valores</span></div>

        <div class="s501-valores">
            @php
                $valores = [
                    ['titulo' => 'Amor Familiar',    'icon' => '❤️', 'desc' => 'Creamos un ambiente acogedor donde las familias pueden disfrutar juntas.'],
                    ['titulo' => 'Pasión Deportiva', 'icon' => '🏆', 'desc' => 'Pantallas HD para que no te pierdas ningún momento de tus equipos favoritos.'],
                    ['titulo' => 'Sabor Casero',     'icon' => '🍴', 'desc' => 'Recetas tradicionales preparadas con ingredientes frescos y mucho cariño.'],
                    ['titulo' => 'Comunidad',        'icon' => '👥', 'desc' => 'Un lugar donde vecinos y amigos se reúnen para celebrar juntos.'],
                ];
            @endphp

            @foreach($valores as $v)
            <div class="s501-card">
                <div class="s501-card-icon">{{ $v['icon'] }}</div>
                <h3>{{ $v['titulo'] }}</h3>
                <p>{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- HISTORIA --}}
        <div class="s501-historia">
            <div class="s501-historia-text">
                <div class="s501-historia-label">
                    <h2>Nuestra <span>Historia</span></h2>
                </div>
                <p>Historia...</p>
                <p>Historia...</p>
                <p>Historia...</p>
            </div>

            <div class="s501-img-wrap">
                <div class="s501-img-glow"></div>
                <div class="s501-img-inner">
                    <img src="{{ asset('images/NH.jpg') }}" alt="Nuestra Historia">
                    <div class="s501-img-badge">
                        <span class="b-icon">🍴</span>
                        <span class="b-years">XX Años</span>
                        <span class="b-label">Sirviendo a nuestra comunidad</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
