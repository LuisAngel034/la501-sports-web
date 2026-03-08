@extends('layouts.app')

@section('content')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;600;700&family=Barlow:wght@400;500&display=swap');

    .ped-page {
        --or:   #F97316;
        --or2:  #EA580C;
        --gn:   #16A34A;
        --gn2:  #22C55E;

        --bg:       #0f0d0a;
        --bg-card:  #161310;
        --bg-card2: #1e1a14;
        --txt:      #FFFFFF;
        --txt-sub:  #A8A29E;
        --bdr:      rgba(255,255,255,0.07);
    }
    :root:not(.dark) .ped-page {
        --bg:       #F5F3EF;
        --bg-card:  #FFFFFF;
        --bg-card2: #EBEBEB;
        --txt:      #1A1208;
        --txt-sub:  #6B6560;
        --bdr:      rgba(0,0,0,0.09);
    }

    /* ── TOPBAR ── */
    .ped-topbar {
        position: relative;
        background: var(--bg-card);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='98'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23F97316' fill-opacity='0.04'%3E%3Cpath d='M28 66L0 49V16L28 0l28 16v33L28 66zm0-2l26-15V18L28 2 2 18v31l26 15zM56 98L28 81 0 98V81L0 66l28-16 28 16v15L28 98l28-17V98z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        border-bottom: 3px solid var(--or);
        padding: 32px 32px 0;
        overflow: hidden;
    }
    .ped-topbar::before {
        content: '';
        position: absolute; top: -60px; left: 50%; transform: translateX(-50%);
        width: 600px; height: 200px;
        background: radial-gradient(ellipse, rgba(249,115,22,.14) 0%, transparent 70%);
        pointer-events: none;
    }
    .ped-topbar-inner {
        max-width: 1200px; margin: 0 auto;
        display: flex; align-items: flex-end;
        justify-content: space-between;
        gap: 24px; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .ped-topbar-badge {
        display: inline-block;
        background: var(--or); color: #fff;
        font-family: 'Oswald', sans-serif;
        font-size: 10px; font-weight: 700;
        letter-spacing: 3px; text-transform: uppercase;
        padding: 4px 16px; margin-bottom: 10px;
        clip-path: polygon(8px 0%,100% 0%,calc(100% - 8px) 100%,0% 100%);
    }
    .ped-topbar-text h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(42px, 7vw, 72px);
        line-height: .95; letter-spacing: 4px;
        color: var(--txt); margin: 0;
    }
    .ped-topbar-text h1 span { color: var(--or); }
    .ped-topbar-text p {
        font-size: 14px; color: var(--txt-sub);
        margin: 8px 0 0; line-height: 1.5;
    }

    /* ── FILTERS ── */
    .ped-filters {
        max-width: 1200px; margin: 0 auto;
        display: flex; gap: 4px;
        padding: 12px 0;
        overflow-x: auto;
        -ms-overflow-style: none; scrollbar-width: none;
    }
    .ped-filters::-webkit-scrollbar { display: none; }
    .ped-filter-btn {
        display: inline-flex; align-items: center; gap: 7px;
        font-family: 'Oswald', sans-serif;
        font-size: 12px; font-weight: 600;
        letter-spacing: 1.5px; text-transform: uppercase;
        padding: 8px 18px; border-radius: 100px;
        border: 1px solid var(--bdr);
        background: transparent; color: var(--txt-sub);
        cursor: pointer; white-space: nowrap;
        transition: background .2s, color .2s, border-color .2s, box-shadow .2s;
        flex-shrink: 0;
    }
    .ped-filter-btn:hover {
        color: var(--or); border-color: rgba(249,115,22,.4);
        background: rgba(249,115,22,.06);
    }
    .ped-filter-btn.active {
        background: var(--or); color: #fff;
        border-color: var(--or);
        box-shadow: 0 3px 16px rgba(249,115,22,.4);
    }
    .ped-filter-btn .fi { font-size: 16px; }

    /* ── SUCCESS BANNER ── */
    .ped-success {
        background: rgba(22,163,74,.1);
        border: 1px solid rgba(34,197,94,.25);
        border-left: 4px solid var(--gn2);
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 28px;
        display: flex; align-items: center; gap: 10px;
        font-family: 'Oswald', sans-serif;
        font-size: 14px; font-weight: 600; letter-spacing: 1px;
        color: var(--gn2);
    }

    /* ── MAIN ── */
    .ped-main {
        max-width: 1200px; margin: 0 auto;
        padding: 40px 32px 80px;
        background-color: var(--bg);
    }

    /* cat label */
    .ped-cat-label {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 28px;
    }
    .ped-cat-label::before {
        content: ''; display: block;
        width: 4px; height: 36px;
        background: linear-gradient(to bottom, var(--or), var(--gn2));
        border-radius: 3px; flex-shrink: 0;
    }
    .ped-cat-label h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 34px; letter-spacing: 3px;
        color: var(--txt); margin: 0; line-height: 1;
    }
    .ped-cat-label .cat-icon { font-size: 24px; }

    /* ── GRID ── */
    .ped-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    /* ── CARD ── */
    .ped-card {
        background: var(--bg-card);
        border: 1px solid var(--bdr);
        border-radius: 16px;
        overflow: hidden;
        display: flex; flex-direction: column;
        position: relative;
        transition: transform .3s, border-color .3s, box-shadow .3s;
    }
    .ped-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(to right, var(--or), var(--gn));
        opacity: 0; transition: opacity .3s;
    }
    .ped-card:hover {
        transform: translateY(-5px);
        border-color: var(--or);
        box-shadow: 0 10px 40px rgba(249,115,22,.16);
    }
    .ped-card:hover::before { opacity: 1; }

    /* image */
    .ped-card-img {
        height: 190px; position: relative;
        overflow: hidden; background: var(--bg-card2); flex-shrink: 0;
    }
    .ped-card-img img {
        position: absolute; inset: 0;
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .6s ease; display: block;
    }
    .ped-card:hover .ped-card-img img { transform: scale(1.1); }
    .ped-card-img-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(10,9,6,.72) 0%, transparent 55%);
        z-index: 1;
    }
    .ped-card-no-img {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 58px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23F97316' fill-opacity='0.04'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15z'/%3E%3C/g%3E%3C/svg%3E");
    }
    .ped-price-badge {
        position: absolute; top: 12px; right: 12px; z-index: 3;
        background: var(--or);
        font-family: 'Bebas Neue', sans-serif;
        font-size: 20px; letter-spacing: 1px; color: #fff;
        padding: 4px 14px; border-radius: 100px;
        box-shadow: 0 3px 14px rgba(249,115,22,.45); line-height: 1.2;
    }

    /* body */
    .ped-card-body {
        padding: 16px 18px 18px;
        display: flex; flex-direction: column; flex-grow: 1;
    }
    .ped-card-body h3 {
        font-family: 'Oswald', sans-serif;
        font-size: 17px; font-weight: 700; letter-spacing: .5px;
        color: var(--txt); margin: 0 0 6px; line-height: 1.2;
        transition: color .25s;
    }
    .ped-card:hover .ped-card-body h3 { color: var(--or); }
    .ped-card-body p {
        font-size: 13px; color: var(--txt-sub);
        line-height: 1.55; flex-grow: 1; margin-bottom: 16px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }

    /* ── ADD BUTTON ── */
    .ped-add-btn {
        width: 100%;
        font-family: 'Oswald', sans-serif;
        font-size: 13px; font-weight: 700;
        letter-spacing: 2px; text-transform: uppercase;
        color: #fff; background: var(--gn);
        border: none; cursor: pointer;
        padding: 13px 0; border-radius: 10px;
        box-shadow: 0 3px 16px rgba(22,163,74,.35);
        transition: background .2s, transform .15s, box-shadow .2s;
    }
    .ped-add-btn:hover {
        background: var(--gn2); transform: translateY(-1px);
        box-shadow: 0 5px 22px rgba(34,197,94,.45);
    }

    /* ── IN-CART CONTROLS ── */
    .ped-in-cart-label {
        font-family: 'Oswald', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: 2px; text-transform: uppercase;
        color: var(--gn2); text-align: center;
        margin-bottom: 10px;
    }
    .ped-qty-row {
        display: flex; align-items: center;
        gap: 8px;
    }
    .ped-qty-btn {
        width: 44px; height: 44px; border-radius: 10px;
        border: none; cursor: pointer;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px; line-height: 1;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s, transform .15s;
        flex-shrink: 0;
    }
    .ped-qty-btn.minus {
        background: rgba(239,68,68,.12);
        color: #F87171;
        border: 1px solid rgba(239,68,68,.2);
    }
    .ped-qty-btn.minus:hover { background: rgba(239,68,68,.22); transform: scale(1.05); }
    .ped-qty-btn.plus {
        background: var(--gn);
        color: #fff;
        box-shadow: 0 2px 10px rgba(22,163,74,.35);
    }
    .ped-qty-btn.plus:hover { background: var(--gn2); transform: scale(1.05); }
    .ped-qty-display {
        flex: 1; height: 44px; border-radius: 10px;
        background: var(--bg-card2);
        border: 1px solid var(--bdr);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px; letter-spacing: 1px;
        color: var(--txt);
    }

    /* ── EMPTY ── */
    .ped-empty {
        grid-column: 1 / -1;
        background: var(--bg-card);
        border: 1px solid var(--bdr);
        border-left: 5px solid var(--or);
        border-radius: 16px;
        padding: 60px 32px; text-align: center;
    }
    .ped-empty-icon { font-size: 48px; display: block; margin-bottom: 12px; }
    .ped-empty h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 34px; letter-spacing: 3px;
        color: var(--txt); margin: 0 0 8px;
    }
    .ped-empty p { color: var(--txt-sub); font-size: 14px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .ped-topbar { padding: 28px 20px 0; }
        .ped-main { padding: 28px 20px 60px; }
        .ped-grid { grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap: 16px; }
    }
    @media (max-width: 420px) {
        .ped-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .ped-card-img { height: 140px; }
    }
</style>

<div class="ped-page" style="background-color: var(--bg);"
     x-data="pedidoManager()" x-init="initMenu()">

    {{-- ── TOPBAR ── --}}
    <div class="ped-topbar">
        <div class="ped-topbar-inner">
            <div class="ped-topbar-text">
                <div class="ped-topbar-badge">La 501 Sports · A Domicilio</div>
                <h1>Arma Tu <span>Pedido</span></h1>
                <p>Agrega tus platillos favoritos y nosotros te los llevamos</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="ped-filters">
            <template x-for="cat in listaCategorias" :key="cat.nombre">
                <button @click="filtro = cat.nombre"
                        :class="filtro === cat.nombre ? 'active' : ''"
                        class="ped-filter-btn">
                    <span class="fi" x-text="cat.icono"></span>
                    <span x-text="cat.nombre"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- ── CONTENT ── --}}
    <div class="ped-main">

        {{-- Success --}}
        @if(session('success'))
        <div class="ped-success">
            ✅ {{ session('success') }}
        </div>
        @endif

        {{-- Cat label --}}
        <div class="ped-cat-label">
            <template x-for="cat in listaCategorias" :key="cat.nombre">
                <template x-if="filtro === cat.nombre">
                    <div style="display:contents;">
                        <span class="cat-icon" x-text="cat.icono"></span>
                        <h2 x-text="filtro"></h2>
                    </div>
                </template>
            </template>
        </div>

        {{-- Grid --}}
        <div class="ped-grid">
            <template x-for="item in productosFiltrados()" :key="item.id">
                <div class="ped-card">

                    {{-- Imagen --}}
                    <div class="ped-card-img">
                        <template x-if="item.image">
                            <img :src="'/storage/' + item.image" :alt="item.name">
                        </template>
                        <template x-if="!item.image">
                            <div class="ped-card-no-img">🍔</div>
                        </template>
                        <div class="ped-card-img-overlay"></div>
                        <div class="ped-price-badge" x-text="'$' + item.price"></div>
                    </div>

                    {{-- Info --}}
                    <div class="ped-card-body">
                        <h3 x-text="item.name"></h3>
                        <p x-text="item.description || 'Delicioso platillo preparado al momento con los mejores ingredientes.'"></p>

                        {{-- ESTADO 1: No está en el carrito --}}
                        <form action="{{ route('cart.add') }}" method="POST" x-show="!isInCart(item.id)">
                            @csrf
                            <input type="hidden" name="id"       :value="item.id">
                            <input type="hidden" name="name"     :value="item.name">
                            <input type="hidden" name="price"    :value="item.price">
                            <input type="hidden" name="image"    :value="item.image || ''">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="ped-add-btn">
                                + Agregar al Pedido
                            </button>
                        </form>

                        {{-- ESTADO 2: Ya está en el carrito --}}
                        <div x-show="isInCart(item.id)" x-cloak>
                            <p class="ped-in-cart-label">✓ En tu pedido</p>
                            <div class="ped-qty-row">
                                {{-- Restar --}}
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id"       :value="item.id">
                                    <input type="hidden" name="quantity" :value="getCartQty(item.id) - 1">
                                    <button type="submit" class="ped-qty-btn minus">−</button>
                                </form>

                                {{-- Cantidad --}}
                                <div class="ped-qty-display">
                                    <span x-text="getCartQty(item.id)"></span>
                                </div>

                                {{-- Sumar --}}
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id"       :value="item.id">
                                    <input type="hidden" name="quantity" :value="parseInt(getCartQty(item.id)) + 1">
                                    <button type="submit" class="ped-qty-btn plus">+</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </template>

            {{-- Empty --}}
            <div x-show="productosFiltrados().length === 0" class="ped-empty" style="display:none;">
                <span class="ped-empty-icon">🍽️</span>
                <h3>Aún No Hay Platillos Aquí</h3>
                <p>Estamos cocinando nuevas opciones para esta categoría.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function pedidoManager() {
        return {
            filtro: 'Hamburguesas',
            listaCategorias: [
                { nombre: 'Hamburguesas',       icono: '🍔' },
                { nombre: 'Jochos',             icono: '🌭' },
                { nombre: 'Burritos',           icono: '🌯' },
                { nombre: 'Tacos',              icono: '🌮' },
                { nombre: 'Strombolis',         icono: '🍕' },
                { nombre: 'Alitas y Costillas', icono: '🍗' },
                { nombre: 'Especialidades',     icono: '🍟' },
                { nombre: 'Opción Fit',         icono: '🥗' },
                { nombre: 'Algo Dulce',         icono: '🍰' },
                { nombre: 'Sin Alcohol',        icono: '🥤' },
                { nombre: 'Cervezas',           icono: '🍺' },
                { nombre: 'Coctelería',         icono: '🍹' },
                { nombre: 'Destilados',         icono: '🥃' },
                { nombre: 'Salsas y Extras',    icono: '🌶️' }
            ],
            allProductos: @json($products ?? []),
            cartData: @json(session('cart', [])),
            lastDataHash: '',

            initMenu() {
                this.lastDataHash = JSON.stringify(this.allProductos);
                const pusher = new Pusher('491d18da8b8b427e4969', { cluster: 'us2' });
                const channel = pusher.subscribe('menu-channel');
                channel.bind('menu.updated', () => { this.fetchLiveProducts(); });
            },

            async fetchLiveProducts() {
                try {
                    const url = `{{ route('api.menu.products') }}?t=${Date.now()}`;
                    const res = await fetch(url, {
                        cache: 'no-store',
                        headers: { 'Pragma': 'no-cache', 'Cache-Control': 'no-cache' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        const hash = JSON.stringify(data);
                        if (this.lastDataHash !== hash) {
                            this.allProductos = data;
                            this.lastDataHash = hash;
                        }
                    }
                } catch(e) { console.error('Error menú en vivo:', e); }
            },

            productosFiltrados() {
                return this.allProductos.filter(p => p.category === this.filtro);
            },
            isInCart(id)    { return this.cartData.hasOwnProperty(id); },
            getCartQty(id)  { return this.cartData[id] ? this.cartData[id].quantity : 0; }
        }
    }
</script>

@endsection