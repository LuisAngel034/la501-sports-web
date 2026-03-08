@extends('layouts.admin')

@section('content')
<style>
.am {
    --ac:  #2563EB; --ac2: #1D4ED8;
    --gn:  #16A34A; --rd:  #DC2626;
    --bg:  #F8F8F8; --card: #FFFFFF;
    --inp: #F4F4F5; --txt:  #18181B;
    --sub: #71717A; --bdr:  #E4E4E7;
}
.dark .am {
    --bg:  #0A0A0A; --card: #111111;
    --inp: #1C1C1C; --txt:  #FAFAFA;
    --sub: #71717A; --bdr:  rgba(255,255,255,.08);
}
.am { background:var(--bg); min-height:100%; padding:28px 32px 60px; color:var(--txt); }

/* ── HEADER ─────────────────────────────── */
.am-hd { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
.am-hd h1 { font-size:20px; font-weight:700; margin:0 0 2px; color:var(--txt); }
.am-hd p  { font-size:13px; color:var(--sub); margin:0; }
.am-btn-add {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; border-radius:7px;
    background:var(--ac); color:#fff; border:none;
    font-size:13px; font-weight:600; cursor:pointer;
    transition:background .15s; box-shadow:0 1px 4px rgba(37,99,235,.25);
}
.am-btn-add:hover { background:var(--ac2); }
.am-btn-add svg { width:14px; height:14px; }

/* ── STATS ───────────────────────────────── */
.am-stats { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; }
.am-stat {
    flex:1; min-width:140px;
    background:var(--card); border:1px solid var(--bdr);
    border-radius:8px; padding:12px 18px;
    display:flex; align-items:center; gap:10px;
}
.am-stat-ico { width:28px; height:28px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.am-stat-ico svg { width:14px; height:14px; }
.am-stat-ico.bl { background:rgba(37,99,235,.1);  color:#2563EB; }
.am-stat-ico.gn { background:rgba(22,163,74,.1);  color:#16A34A; }
.am-stat-ico.gy { background:rgba(113,113,122,.1);color:#71717A; }
.am-stat-ico.or { background:rgba(249,115,22,.1); color:#EA580C; }
.dark .am-stat-ico.bl { color:#60A5FA; }
.dark .am-stat-ico.gn { color:#4ADE80; }
.dark .am-stat-ico.or { color:#FB923C; }
.am-stat-v { font-size:20px; font-weight:800; letter-spacing:-.3px; color:var(--txt); margin:0 0 1px; line-height:1; }
.am-stat-l { font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.6px; color:var(--sub); }

/* ── FILTROS ─────────────────────────────── */
.am-filters {
    display:flex; gap:6px; overflow-x:auto; padding-bottom:4px; margin-bottom:14px;
    scrollbar-width:none; -ms-overflow-style:none;
}
.am-filters::-webkit-scrollbar { display:none; }
.am-fbtn {
    padding:6px 14px; border-radius:6px; font-size:12px; font-weight:600;
    border:1px solid var(--bdr); background:var(--card); color:var(--sub);
    cursor:pointer; white-space:nowrap; flex-shrink:0;
    transition:background .15s, color .15s, border-color .15s;
}
.am-fbtn:hover { color:var(--txt); border-color:#C4C4C8; }
.am-fbtn.on { background:var(--ac); color:#fff; border-color:var(--ac); }

/* ── TABLE CARD ──────────────────────────── */
.am-card { background:var(--card); border:1px solid var(--bdr); border-radius:10px; overflow:hidden; }
.am-card-hd { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-bottom:1px solid var(--bdr); }
.am-card-ttl { display:flex; align-items:center; gap:8px; }
.am-card-ttl-ico { width:26px; height:26px; border-radius:6px; background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.14); display:flex; align-items:center; justify-content:center; }
.am-card-ttl-ico svg { width:13px; height:13px; color:var(--ac); }
.am-card-ttl span { font-size:13px; font-weight:700; color:var(--txt); }
.am-badge { font-size:11px; font-weight:600; color:var(--sub); background:var(--inp); border:1px solid var(--bdr); border-radius:20px; padding:2px 9px; }

/* ── ROWS ────────────────────────────────── */
.am-row { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; gap:14px; border-bottom:1px solid var(--bdr); transition:background .15s; }
.am-row:last-child { border-bottom:none; }
.am-row:hover { background:var(--bg); }
.am-row-l { display:flex; align-items:center; gap:12px; flex:1; min-width:0; }
.am-thumb { width:48px; height:48px; border-radius:8px; object-fit:cover; flex-shrink:0; border:1px solid var(--bdr); background:var(--inp); }
.am-thumb-ph { width:48px; height:48px; border-radius:8px; background:var(--inp); border:1px solid var(--bdr); display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; }
.am-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
.am-dot.on  { background:#22C55E; box-shadow:0 0 0 2px rgba(34,197,94,.2); }
.am-dot.off { background:#71717A; }
.am-row-info { min-width:0; }
.am-row-name { font-size:13px; font-weight:600; color:var(--txt); margin:0 0 2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.am-row-name.off { color:var(--sub); text-decoration:line-through; }
.am-row-meta { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
.am-chip-cat { font-size:10px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; background:var(--inp); color:var(--sub); border:1px solid var(--bdr); border-radius:4px; padding:1px 7px; }
.am-chip-sub { font-size:10px; font-weight:600; background:rgba(37,99,235,.07); color:var(--ac); border:1px solid rgba(37,99,235,.15); border-radius:4px; padding:1px 7px; }
.am-price { font-size:12px; font-weight:700; color:var(--gn); }
.am-row-actions { display:flex; gap:6px; flex-shrink:0; }
.am-act { width:32px; height:32px; border-radius:6px; border:1px solid var(--bdr); background:var(--inp); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--sub); transition:background .15s, border-color .15s, color .15s; }
.am-act svg { width:13px; height:13px; }
.am-act.ed:hover { border-color:var(--ac); color:var(--ac); background:rgba(37,99,235,.06); }
.am-act.dl:hover { border-color:var(--rd); color:var(--rd); background:rgba(220,38,38,.06); }

/* ── EMPTY ───────────────────────────────── */
.am-empty { padding:60px 20px; text-align:center; }
.am-empty svg { width:36px; height:36px; color:var(--bdr); margin:0 auto 10px; display:block; }
.am-empty p { font-size:13px; color:var(--sub); margin:0; }

/* ══════════════════════════════════════════════
   MODAL
══════════════════════════════════════════════ */
.am-overlay {
    position:fixed; inset:0; z-index:50;
    background:rgba(0,0,0,.55); backdrop-filter:blur(4px);
    display:flex; align-items:flex-start; justify-content:center;
    padding:40px 16px 60px; overflow-y:auto;
}
.am-modal { background:var(--card); border:1px solid var(--bdr); border-radius:12px; width:100%; max-width:600px; box-shadow:0 24px 64px rgba(0,0,0,.24); flex-shrink:0; }
.am-mhd { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid var(--bdr); position:sticky; top:0; z-index:2; background:var(--card); border-radius:12px 12px 0 0; }
.am-mhd h3 { font-size:15px; font-weight:700; color:var(--txt); margin:0 0 2px; }
.am-mhd p  { font-size:12px; color:var(--sub); margin:0; }
.am-mclose { width:28px; height:28px; border-radius:7px; background:var(--inp); border:1px solid var(--bdr); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--sub); transition:background .15s; flex-shrink:0; }
.am-mclose:hover { background:var(--bdr); }
.am-mclose svg { width:13px; height:13px; }
.am-mbody { padding:20px; display:flex; flex-direction:column; gap:18px; }
.am-sec { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:var(--sub); padding-bottom:8px; border-bottom:1px solid var(--bdr); }

/* imagen */
.am-imgbox { position:relative; border-radius:10px; overflow:hidden; border:2px dashed var(--bdr); background:var(--inp); height:150px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:border-color .2s; }
.am-imgbox:hover { border-color:var(--ac); }
.am-imgph { text-align:center; pointer-events:none; }
.am-imgph svg { width:28px; height:28px; color:var(--sub); margin:0 auto 6px; display:block; }
.am-imgph p { font-size:12px; color:var(--sub); margin:0; }
.am-imgprev { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
.am-imgovl { position:absolute; inset:0; background:rgba(0,0,0,.42); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .2s; pointer-events:none; font-size:12px; color:#fff; font-weight:600; gap:6px; }
.am-imgovl svg { width:15px; height:15px; }
.am-imgbox:hover .am-imgovl { opacity:1; }

/* grid y campos */
.am-g2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.am-lbl { display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); margin-bottom:5px; }
.am-lbl .req { color:var(--ac); }
.am-inp, .am-sel, .am-ta {
    width:100%; padding:8px 10px; background:var(--inp); border:1px solid var(--bdr);
    border-radius:7px; font-size:13px; color:var(--txt); outline:none;
    transition:border-color .15s, box-shadow .15s; font-family:inherit;
}
.am-inp:focus, .am-sel:focus, .am-ta:focus { border-color:var(--ac); box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.am-ta  { resize:vertical; min-height:72px; }
.am-sel { cursor:pointer; }

/* subcategoría notice */
.am-subnotice { margin-top:6px; padding:6px 10px; border-radius:6px; font-size:11px; color:var(--ac); background:rgba(37,99,235,.06); border:1px solid rgba(37,99,235,.14); }

/* toggle */
.am-trow { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; border-radius:8px; background:var(--inp); border:1px solid var(--bdr); }
.am-tlbl { font-size:13px; font-weight:600; color:var(--txt); margin:0 0 2px; }
.am-tsub { font-size:11px; color:var(--sub); }
.am-tog  { position:relative; width:38px; height:22px; flex-shrink:0; }
.am-tog input { opacity:0; width:0; height:0; }
.am-tog-sl { position:absolute; inset:0; border-radius:20px; background:var(--bdr); cursor:pointer; transition:background .2s; }
.am-tog-sl::before { content:''; position:absolute; left:3px; top:3px; width:16px; height:16px; border-radius:50%; background:#fff; transition:transform .2s; }
.am-tog input:checked + .am-tog-sl { background:var(--gn); }
.am-tog input:checked + .am-tog-sl::before { transform:translateX(16px); }

/* ── INGREDIENTES con autocomplete ───────── */
.am-ing-wrap { position:relative; }
.am-ing-search {
    position:relative;
}
.am-ing-search-ico {
    position:absolute; left:9px; top:50%; transform:translateY(-50%);
    width:13px; height:13px; color:var(--sub); pointer-events:none;
}
.am-ing-search .am-inp { padding-left:30px; }

/* dropdown lista */
.am-ing-dropdown {
    position:absolute; top:calc(100% + 4px); left:0; right:0;
    background:var(--card); border:1px solid var(--bdr);
    border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,.12);
    z-index:60; overflow:hidden;
    max-height:200px; display:flex; flex-direction:column;
}
.am-ing-dd-search {
    padding:8px 10px; border-bottom:1px solid var(--bdr);
    display:flex; align-items:center; gap:8px; flex-shrink:0;
}
.am-ing-dd-search svg { width:13px; height:13px; color:var(--sub); flex-shrink:0; }
.am-ing-dd-search input {
    flex:1; background:none; border:none; outline:none;
    font-size:12px; color:var(--txt); font-family:inherit;
}
.am-ing-dd-search input::placeholder { color:var(--sub); }
.am-ing-dd-list { overflow-y:auto; flex:1; scrollbar-width:thin; scrollbar-color:var(--bdr) transparent; }
.am-ing-dd-list::-webkit-scrollbar { width:4px; }
.am-ing-dd-list::-webkit-scrollbar-thumb { background:var(--bdr); border-radius:4px; }
.am-ing-dd-item {
    padding:8px 12px; font-size:12px; font-weight:500; color:var(--txt);
    cursor:pointer; display:flex; align-items:center; gap:8px;
    border-bottom:1px solid var(--bdr); transition:background .1s;
}
.am-ing-dd-item:last-child { border-bottom:none; }
.am-ing-dd-item:hover { background:rgba(37,99,235,.06); color:var(--ac); }
.am-ing-dd-item svg { width:11px; height:11px; color:var(--sub); flex-shrink:0; }
.am-ing-dd-empty { padding:14px 12px; font-size:12px; color:var(--sub); text-align:center; font-style:italic; }

/* chip ingrediente seleccionado */
.am-ing-chips { display:flex; flex-wrap:wrap; gap:6px; }
.am-ing-chip {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 10px; border-radius:20px;
    background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.18);
    font-size:12px; font-weight:600; color:var(--ac);
}
.am-ing-chip button {
    width:14px; height:14px; border-radius:50%;
    background:rgba(37,99,235,.15); border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    color:var(--ac); line-height:1; padding:0;
    transition:background .15s;
}
.am-ing-chip button:hover { background:rgba(220,38,38,.2); color:var(--rd); }
.am-ing-chip button svg { width:8px; height:8px; }
.am-ing-add-btn {
    display:inline-flex; align-items:center; gap:5px;
    font-size:12px; font-weight:600; color:var(--ac);
    background:rgba(37,99,235,.07); border:1px solid rgba(37,99,235,.14);
    border-radius:20px; padding:5px 12px; cursor:pointer; transition:background .15s;
}
.am-ing-add-btn:hover { background:rgba(37,99,235,.13); }
.am-ing-add-btn svg { width:11px; height:11px; }

/* modal footer */
.am-mfoot { padding:14px 20px; border-top:1px solid var(--bdr); display:flex; align-items:center; justify-content:flex-end; gap:8px; }
.am-btn-cancel { padding:8px 16px; border-radius:7px; background:var(--inp); border:1px solid var(--bdr); font-size:13px; font-weight:600; color:var(--sub); cursor:pointer; transition:background .15s; }
.am-btn-cancel:hover { background:var(--bdr); }
.am-btn-save { padding:8px 20px; border-radius:7px; background:var(--ac); color:#fff; border:none; font-size:13px; font-weight:600; cursor:pointer; transition:background .15s; display:flex; align-items:center; gap:6px; }
.am-btn-save:hover { background:var(--ac2); }
.am-btn-save svg { width:14px; height:14px; }

@media(max-width:640px){
    .am { padding:20px 16px 40px; }
    .am-stats { display:grid; grid-template-columns:1fr 1fr; }
    .am-g2 { grid-template-columns:1fr; }
    .am-overlay { padding:20px 12px 40px; }
}
</style>

<div class="am" x-data="menuAdmin()" x-init="init()">

    {{-- HEADER --}}
    <div class="am-hd">
        <div>
            <h1>Gestionar Menú</h1>
            <p>{{ $products->count() }} platillos registrados</p>
        </div>
        <button @click="openNew()" class="am-btn-add">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Platillo
        </button>
    </div>

    {{-- STATS --}}
    <div class="am-stats">
        <div class="am-stat">
            <div class="am-stat-ico bl">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div><p class="am-stat-v">{{ $products->count() }}</p><p class="am-stat-l">Total</p></div>
        </div>
        <div class="am-stat">
            <div class="am-stat-ico gn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div><p class="am-stat-v">{{ $products->where('available', true)->count() }}</p><p class="am-stat-l">Disponibles</p></div>
        </div>
        <div class="am-stat">
            <div class="am-stat-ico gy">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <div><p class="am-stat-v">{{ $products->where('available', false)->count() }}</p><p class="am-stat-l">No disponibles</p></div>
        </div>
        <div class="am-stat">
            <div class="am-stat-ico or">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div><p class="am-stat-v">{{ $products->pluck('category')->unique()->count() }}</p><p class="am-stat-l">Categorías</p></div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="am-filters">
        <button @click="filter='todos'" :class="filter==='todos'?'on':''" class="am-fbtn">Todos</button>
        <template x-for="cat in categorias" :key="cat">
            <button @click="filter=cat" :class="filter===cat?'on':''" class="am-fbtn" x-text="cat"></button>
        </template>
    </div>

    {{-- TABLE --}}
    <div class="am-card">
        <div class="am-card-hd">
            <div class="am-card-ttl">
                <div class="am-card-ttl-ico">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </div>
                <span>Platillos</span>
            </div>
            <span class="am-badge">{{ $products->count() }} registros</span>
        </div>

        @foreach($products as $product)
        <div class="am-row"
             x-show="filter==='todos'||filter==='{{ $product->category }}'"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

            <div class="am-row-l">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="am-thumb" alt="{{ $product->name }}">
                @else
                    <div class="am-thumb-ph">🍔</div>
                @endif
                <div class="am-dot {{ $product->available ? 'on' : 'off' }}"></div>
                <div class="am-row-info">
                    <p class="am-row-name {{ $product->available ? '' : 'off' }}">{{ $product->name }}</p>
                    <div class="am-row-meta">
                        <span class="am-chip-cat">{{ $product->category }}</span>
                        @if($product->subcategory)
                            <span class="am-chip-sub">{{ $product->subcategory }}</span>
                        @endif
                        <span class="am-price">${{ number_format($product->price, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="am-row-actions">
                <button class="am-act ed" title="Editar"
                        @click="openEdit({{ $product }}, {{ $product->ingredientes->pluck('nombre') }})">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </button>
                <form action="{{ route('admin.menu.destroy', $product->id) }}" method="POST"
                      @submit.prevent="confirmDelete($el)">
                    @csrf @method('DELETE')
                    <button type="submit" class="am-act dl" title="Eliminar">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach

        @if($products->isEmpty())
        <div class="am-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p>No hay platillos registrados aún.</p>
        </div>
        @endif
    </div>
    <div x-show="modalOpen" x-cloak class="am-overlay" @click.self="modalOpen=false">
        <div class="am-modal" @click.stop>

            <div class="am-mhd">
                <div>
                    <h3 x-text="isEdit ? 'Editar Platillo' : 'Nuevo Platillo'"></h3>
                    <p x-text="isEdit ? 'Modifica los datos del platillo seleccionado' : 'Completa la información del nuevo platillo'"></p>
                </div>
                <button @click="modalOpen=false" class="am-mclose">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="formAction" method="POST" enctype="multipart/form-data">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                {{-- hidden inputs para ingredientes seleccionados --}}
                <template x-for="(ing, idx) in ingredients" :key="idx">
                    <input type="hidden" :name="'ingredients['+idx+']'" :value="ing">
                </template>

                <div class="am-mbody">

                    {{-- ── Imagen ── --}}
                    <div>
                        <p class="am-sec">Imagen</p>
                        <div class="am-imgbox" style="margin-top:10px" @click="$refs.imgFile.click()">
                            <input type="file" name="image" accept="image/*"
                                   x-ref="imgFile" style="display:none"
                                   @change="previewImage($event)">
                            <template x-if="!imagePreview">
                                <div class="am-imgph">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p>Haz clic para subir imagen</p>
                                </div>
                            </template>
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="am-imgprev">
                            </template>
                            <div class="am-imgovl">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Cambiar imagen
                            </div>
                        </div>
                    </div>

                    {{-- ── Disponible ── --}}
                    <div class="am-trow">
                        <div>
                            <p class="am-tlbl">Disponible en menú</p>
                            <p class="am-tsub">El platillo será visible para los clientes</p>
                        </div>
                        <label class="am-tog">
                            <input type="checkbox" name="available" value="1" x-model="formData.available">
                            <span class="am-tog-sl"></span>
                        </label>
                    </div>

                    {{-- ── Info básica ── --}}
                    <div>
                        <p class="am-sec">Información básica</p>
                        <div class="am-g2" style="margin-top:10px">
                            <div>
                                <label class="am-lbl">Nombre <span class="req">*</span></label>
                                <input type="text" name="name" class="am-inp"
                                       x-model="formData.name" placeholder="Ej: Hamburguesa La 501" required>
                            </div>
                            <div>
                                <label class="am-lbl">Precio ($) <span class="req">*</span></label>
                                <input type="number" name="price" class="am-inp"
                                       step="0.01" min="0" x-model="formData.price"
                                       placeholder="0.00" required>
                            </div>
                        </div>
                        <div style="margin-top:12px">
                            <label class="am-lbl">Descripción</label>
                            <textarea name="description" class="am-ta"
                                      x-model="formData.description"
                                      placeholder="Describe brevemente el platillo..."></textarea>
                        </div>
                    </div>

                    {{-- ── Clasificación ── --}}
                    <div>
                        <p class="am-sec">Clasificación</p>
                        <div class="am-g2" style="margin-top:10px">

                            {{-- Categoría --}}
                            <div>
                                <label class="am-lbl">Categoría <span class="req">*</span></label>
                                <select name="category" class="am-sel"
                                        x-model="formData.category"
                                        @change="formData.subcategory=''">
                                    <optgroup label="Comida Fuerte">
                                        <option value="Hamburguesas">Hamburguesas</option>
                                        <option value="Jochos">Jochos</option>
                                        <option value="Burritos">Burritos</option>
                                        <option value="Tacos">Tacos</option>
                                        <option value="Strombolis">Strombolis</option>
                                        <option value="Alitas y Costillas">Alitas y Costillas</option>
                                    </optgroup>
                                    <optgroup label="Complementos">
                                        <option value="Especialidades">Especialidades</option>
                                        <option value="Opción Fit">Opción Fit</option>
                                        <option value="Salsas y Extras">Salsas y Extras</option>
                                    </optgroup>
                                    <optgroup label="Postres &amp; Bebidas">
                                        <option value="Algo Dulce">Algo Dulce</option>
                                        <option value="Sin Alcohol">Sin Alcohol</option>
                                    </optgroup>
                                    <optgroup label="Bar">
                                        <option value="Cervezas">Cervezas</option>
                                        <option value="Coctelería">Coctelería</option>
                                        <option value="Destilados">Destilados</option>
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Subcategoría — SOLO para Coctelería / Destilados --}}
                            <div>
                                <label class="am-lbl">
                                    Subcategoría
                                    <template x-if="subcatMap[formData.category]">
                                        <span class="req"> *</span>
                                    </template>
                                </label>

                                <template x-if="subcatMap[formData.category]">
                                    <div>
                                        <select name="subcategory" class="am-sel" x-model="formData.subcategory">
                                            <option value="">— Selecciona base —</option>
                                            <template x-for="opt in subcatMap[formData.category]" :key="opt">
                                                <option :value="opt" x-text="opt"></option>
                                            </template>
                                        </select>
                                        <p class="am-subnotice">Selecciona la base de la bebida.</p>
                                    </div>
                                </template>

                                <template x-if="!subcatMap[formData.category]">
                                    <input type="text" name="subcategory" class="am-inp"
                                           x-model="formData.subcategory" placeholder="Opcional">
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         INGREDIENTES — búsqueda en inventario
                         Todo en el scope de menuAdmin(), sin x-data anidado
                    ══════════════════════════════════════════ --}}
                    <div>
                        <p class="am-sec">Ingredientes</p>

                        {{-- Chips de ingredientes seleccionados --}}
                        <div class="am-ing-chips" style="margin-top:10px; margin-bottom:10px; min-height:28px;">
                            <template x-if="ingredients.length === 0">
                                <span style="font-size:12px; color:var(--sub); font-style:italic;">
                                    Ningún ingrediente añadido aún
                                </span>
                            </template>
                            <template x-for="(ing, idx) in ingredients" :key="idx">
                                <span class="am-ing-chip">
                                    <span x-text="ing"></span>
                                    <button type="button" @click.prevent="removeIngredient(idx)" title="Quitar">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </span>
                            </template>
                        </div>

                        {{-- Buscador — lógica directamente en menuAdmin() --}}
                        <div class="am-ing-wrap">
                            <div class="am-ing-search">
                                <svg class="am-ing-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                                <input type="text" class="am-inp"
                                       placeholder="Buscar ingrediente del inventario..."
                                       x-model="ingQuery"
                                       @focus="ingOpen=true"
                                       @input="ingOpen=true"
                                       @keydown.escape="ingOpen=false"
                                       @keydown.enter.prevent="ingPickFirst()"
                                       autocomplete="off"
                                       x-ref="ingInput">
                            </div>

                            {{-- Dropdown — se cierra con @mousedown.prevent en los items
                                 para que el click llegue ANTES de que el blur del input lo cierre --}}
                            <div class="am-ing-dropdown"
                                 x-show="ingOpen && ingFiltered().length > 0"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                                <div class="am-ing-dd-list">
                                    <template x-for="item in ingFiltered()" :key="item.id">
                                        <div class="am-ing-dd-item"
                                             @mousedown.prevent="ingSelect(item)">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            <span x-text="item.name"></span>
                                            <template x-if="ingredients.includes(item.name)">
                                                <svg style="margin-left:auto;color:var(--gn);width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- Sin resultados --}}
                            <div x-show="ingOpen && ingQuery.trim() && ingFiltered().length === 0"
                                 class="am-ing-dd-empty" style="border:1px solid var(--bdr); border-radius:8px; margin-top:4px;">
                                Sin coincidencias en inventario
                            </div>
                        </div>

                        {{-- Botón ingrediente libre --}}
                        <button type="button" class="am-ing-add-btn" style="margin-top:8px"
                                @click.prevent="ingAddFree()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Escribir ingrediente libre
                        </button>

                    </div>
                    {{-- /INGREDIENTES --}}

                </div>{{-- /am-mbody --}}

                <div class="am-mfoot">
                    <button type="button" @click="modalOpen=false" class="am-btn-cancel">Cancelar</button>
                    <button type="submit" class="am-btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Platillo'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<script>
const INVENTARIO = @json($inventario);   {{-- [{id, name}, ...] --}}

function menuAdmin() {
    return {
        /* Lista */
        filter: 'todos',
        categorias: [
            'Hamburguesas','Jochos','Burritos','Tacos','Strombolis',
            'Alitas y Costillas','Especialidades','Opción Fit',
            'Algo Dulce','Sin Alcohol','Cervezas','Coctelería',
            'Destilados','Salsas y Extras',
        ],

        /* Modal */
        modalOpen:    false,
        isEdit:       false,
        formAction:   '{{ route('admin.menu.store') }}',
        imagePreview: null,

        formData: {
            name:'', description:'', price:'',
            category:'Hamburguesas', subcategory:'', available:true,
        },

        /* Ingredientes seleccionados */
        ingredients: [],

        /* Buscador de ingredientes */
        ingQuery: '',
        ingOpen:  false,

        /* Subcategorías predefinidas solo para Bar */
        subcatMap: {
            'Coctelería': ['Ron','Vodka','Tequila','Mezcal','Ginebra','Digestivos'],
            'Destilados': ['Tequila','Ron','Brandy','Vodka','Whisky','Mezcal','Copeo','6 Shots'],
        },

        init() {},

        openNew() {
            this.isEdit       = false;
            this.formAction   = '{{ route('admin.menu.store') }}';
            this.imagePreview = null;
            this.ingredients  = [];
            this.ingQuery     = '';
            this.ingOpen      = false;
            this.formData     = {
                name:'', description:'', price:'',
                category:'Hamburguesas', subcategory:'', available:true,
            };
            this.modalOpen = true;
        },

        openEdit(product, ingList) {
            this.isEdit       = true;
            this.formAction   = `/admin/menu/${product.id}`;
            this.formData     = { ...product, available: Boolean(product.available) };
            this.ingredients  = (ingList && ingList.length > 0) ? [...ingList] : [];
            this.ingQuery     = '';
            this.ingOpen      = false;
            this.imagePreview = product.image ? `/storage/${product.image}` : null;
            this.modalOpen    = true;
        },

        previewImage(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => { this.imagePreview = ev.target.result; };
            reader.readAsDataURL(file);
        },

        removeIngredient(idx) { this.ingredients.splice(idx, 1); },

        ingFiltered() {
            const q = this.ingQuery.trim().toLowerCase();
            if (!q) return INVENTARIO;
            return INVENTARIO.filter(i => i.name.toLowerCase().includes(q));
        },

        ingSelect(item) {
            if (!this.ingredients.includes(item.name)) {
                this.ingredients.push(item.name);
            }
            this.ingQuery = '';
            this.ingOpen  = false;
        },

        ingPickFirst() {
            const results = this.ingFiltered();
            if (results.length > 0) {
                this.ingSelect(results[0]);
            } else if (this.ingQuery.trim()) {
                this.ingAddFree(this.ingQuery.trim());
            }
        },

        ingAddFree(val = null) {
            const name = val ?? prompt('Escribe el nombre del ingrediente:');
            if (name && name.trim() && !this.ingredients.includes(name.trim())) {
                this.ingredients.push(name.trim());
            }
            this.ingQuery = '';
            this.ingOpen  = false;
        },

        confirmDelete(form) {
            if (confirm('¿Eliminar este platillo?\nEsta acción no se puede deshacer.')) {
                form.submit();
            }
        },
    }
}
</script>

@endsection