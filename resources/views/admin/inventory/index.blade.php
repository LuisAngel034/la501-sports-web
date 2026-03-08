@extends('layouts.admin')

@section('content')
<style>
.inv {
    --ac:   #2563EB; --ac2:  #1D4ED8;
    --gn:   #16A34A; --gn2:  #22C55E;
    --rd:   #DC2626; --rd2:  #EF4444;
    --am:   #D97706; --am2:  #F59E0B;
    --bg:   #F8F8F8; --card: #FFFFFF;
    --inp:  #F4F4F5; --txt:  #18181B;
    --sub:  #71717A; --bdr:  #E4E4E7;
}
.dark .inv {
    --bg:   #0A0A0A; --card: #111111;
    --inp:  #1C1C1C; --txt:  #FAFAFA;
    --sub:  #71717A; --bdr:  rgba(255,255,255,.08);
}
.inv { background:var(--bg); min-height:100%; padding:28px 32px 60px; color:var(--txt); }

/* ── HEADER ──────────────────────────────── */
.inv-hd { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
.inv-hd h1 { font-size:20px; font-weight:700; color:var(--txt); margin:0 0 2px; }
.inv-hd p  { font-size:13px; color:var(--sub); margin:0; }
.inv-btn-add {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 16px; border-radius:7px;
    background:var(--ac); color:#fff; border:none;
    font-size:13px; font-weight:600; cursor:pointer;
    transition:background .15s; box-shadow:0 1px 4px rgba(37,99,235,.25);
}
.inv-btn-add:hover { background:var(--ac2); }
.inv-btn-add svg { width:14px; height:14px; }

/* ── STATS ───────────────────────────────── */
.inv-stats { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; }
.inv-stat {
    flex:1; min-width:160px;
    background:var(--card); border:1px solid var(--bdr);
    border-radius:8px; padding:12px 18px;
    display:flex; align-items:center; gap:12px;
}
.inv-stat-ico { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.inv-stat-ico svg { width:15px; height:15px; }
.inv-stat-ico.bl  { background:rgba(37,99,235,.1);  color:#2563EB; }
.inv-stat-ico.rd  { background:rgba(220,38,38,.1);  color:#DC2626; }
.inv-stat-ico.am  { background:rgba(217,119,6,.1);  color:#D97706; }
.inv-stat-ico.gn  { background:rgba(22,163,74,.1);  color:#16A34A; }
.dark .inv-stat-ico.bl { color:#60A5FA; }
.dark .inv-stat-ico.rd { color:#F87171; }
.dark .inv-stat-ico.am { color:#FCD34D; }
.dark .inv-stat-ico.gn { color:#4ADE80; }
.inv-stat-v { font-size:22px; font-weight:800; letter-spacing:-.5px; color:var(--txt); margin:0 0 1px; line-height:1; }
.inv-stat-l { font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.6px; color:var(--sub); }

/* ── SEARCH + FILTER BAR ─────────────────── */
.inv-bar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:14px; }
.inv-search {
    position:relative; flex:1; min-width:200px;
}
.inv-search svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:var(--sub); pointer-events:none; }
.inv-search input {
    width:100%; padding:8px 10px 8px 32px;
    background:var(--card); border:1px solid var(--bdr);
    border-radius:7px; font-size:13px; color:var(--txt);
    outline:none; transition:border-color .15s, box-shadow .15s;
    font-family:inherit;
}
.inv-search input:focus { border-color:var(--ac); box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.inv-filter-btn {
    padding:6px 14px; border-radius:6px; font-size:12px; font-weight:600;
    border:1px solid var(--bdr); background:var(--card); color:var(--sub);
    cursor:pointer; white-space:nowrap; flex-shrink:0;
    transition:background .15s, color .15s, border-color .15s;
}
.inv-filter-btn:hover { color:var(--txt); border-color:#C4C4C8; }
.inv-filter-btn.on { background:var(--ac); color:#fff; border-color:var(--ac); }
.inv-filter-btn.rd-on { background:var(--rd); color:#fff; border-color:var(--rd); }

/* ── TABLE CARD ──────────────────────────── */
.inv-card { background:var(--card); border:1px solid var(--bdr); border-radius:10px; overflow:hidden; }
.inv-card-hd { display:flex; align-items:center; justify-content:space-between; padding:12px 18px; border-bottom:1px solid var(--bdr); }
.inv-card-ttl { display:flex; align-items:center; gap:8px; }
.inv-card-ttl-ico { width:26px; height:26px; border-radius:6px; background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.14); display:flex; align-items:center; justify-content:center; }
.inv-card-ttl-ico svg { width:13px; height:13px; color:var(--ac); }
.inv-card-ttl span { font-size:13px; font-weight:700; color:var(--txt); }
.inv-badge { font-size:11px; font-weight:600; color:var(--sub); background:var(--inp); border:1px solid var(--bdr); border-radius:20px; padding:2px 9px; }

/* table */
.inv-table { width:100%; border-collapse:collapse; min-width:700px; }
.inv-table th {
    padding:10px 16px; font-size:10px; font-weight:700;
    text-transform:uppercase; letter-spacing:.6px; color:var(--sub);
    background:var(--inp); border-bottom:1px solid var(--bdr);
    white-space:nowrap;
}
.inv-table th:first-child { border-radius:0; }
.inv-table td { padding:12px 16px; border-bottom:1px solid var(--bdr); vertical-align:middle; }
.inv-table tr:last-child td { border-bottom:none; }
.inv-table tbody tr { transition:background .12s; }
.inv-table tbody tr:hover { background:var(--bg); }

/* nombre */
.inv-name { font-size:13px; font-weight:600; color:var(--txt); margin:0 0 2px; }
.inv-id   { font-size:11px; color:var(--sub); }

/* categoria chip */
.inv-cat-chip {
    display:inline-flex; align-items:center; gap:5px;
    font-size:11px; font-weight:600; color:var(--sub);
    background:var(--inp); border:1px solid var(--bdr);
    border-radius:5px; padding:2px 8px;
}
.inv-cat-chip span { font-size:13px; }

/* stock badge */
.inv-stock {
    display:inline-flex; align-items:center; gap:6px;
    padding:4px 10px; border-radius:20px;
    font-size:13px; font-weight:700;
}
.inv-stock.ok  { background:rgba(22,163,74,.08);  color:var(--gn);  border:1px solid rgba(22,163,74,.2);  }
.inv-stock.low { background:rgba(220,38,38,.08);  color:var(--rd);  border:1px solid rgba(220,38,38,.2);  }
.inv-stock.mid { background:rgba(217,119,6,.08);  color:var(--am);  border:1px solid rgba(217,119,6,.2);  }
.inv-stock svg { width:10px; height:10px; }
.inv-stock-unit { font-size:10px; font-weight:600; opacity:.7; }

/* mini progress bar */
.inv-progress { width:80px; height:4px; background:var(--bdr); border-radius:2px; overflow:hidden; }
.inv-progress-fill { height:100%; border-radius:2px; transition:width .3s; }
.inv-progress-fill.ok  { background:var(--gn2); }
.inv-progress-fill.low { background:var(--rd2); }
.inv-progress-fill.mid { background:var(--am2); }

/* acciones */
.inv-actions { display:flex; gap:6px; justify-content:flex-end; }
.inv-act {
    width:30px; height:30px; border-radius:6px;
    border:1px solid var(--bdr); background:var(--inp);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; color:var(--sub);
    transition:background .15s, border-color .15s, color .15s;
}
.inv-act svg { width:13px; height:13px; }
.inv-act.adj:hover { border-color:var(--gn);  color:var(--gn);  background:rgba(22,163,74,.06); }
.inv-act.ed:hover  { border-color:var(--ac);  color:var(--ac);  background:rgba(37,99,235,.06); }
.inv-act.dl:hover  { border-color:var(--rd);  color:var(--rd);  background:rgba(220,38,38,.06); }

/* empty */
.inv-empty { padding:60px 20px; text-align:center; }
.inv-empty svg { width:36px; height:36px; color:var(--bdr); margin:0 auto 10px; display:block; }
.inv-empty p { font-size:13px; color:var(--sub); margin:0; }

/* overflow wrapper */
.inv-table-wrap { overflow-x:auto; scrollbar-width:thin; scrollbar-color:var(--bdr) transparent; }
.inv-table-wrap::-webkit-scrollbar { height:4px; }
.inv-table-wrap::-webkit-scrollbar-thumb { background:var(--bdr); border-radius:4px; }

/* ══════════════════════════════════════════════
   MODALES — mismo estilo que admin-menu
══════════════════════════════════════════════ */
.inv-overlay {
    position:fixed; inset:0; z-index:50;
    background:rgba(0,0,0,.55); backdrop-filter:blur(4px);
    display:flex; align-items:flex-start; justify-content:center;
    padding:40px 16px 60px; overflow-y:auto;
}
.inv-modal { background:var(--card); border:1px solid var(--bdr); border-radius:12px; width:100%; max-width:520px; box-shadow:0 24px 64px rgba(0,0,0,.24); flex-shrink:0; }
.inv-modal.sm { max-width:400px; }

/* modal header */
.inv-mhd { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid var(--bdr); position:sticky; top:0; z-index:2; background:var(--card); border-radius:12px 12px 0 0; }
.inv-mhd h3 { font-size:15px; font-weight:700; color:var(--txt); margin:0 0 2px; }
.inv-mhd p  { font-size:12px; color:var(--sub); margin:0; }
.inv-mclose { width:28px; height:28px; border-radius:7px; background:var(--inp); border:1px solid var(--bdr); display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--sub); transition:background .15s; flex-shrink:0; }
.inv-mclose:hover { background:var(--bdr); }
.inv-mclose svg { width:13px; height:13px; }

/* modal body */
.inv-mbody { padding:20px; display:flex; flex-direction:column; gap:16px; }
.inv-sec { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:var(--sub); padding-bottom:8px; border-bottom:1px solid var(--bdr); }
.inv-g2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.inv-g3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; }
.inv-lbl { display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); margin-bottom:5px; }
.inv-lbl .req { color:var(--ac); }
.inv-inp, .inv-sel {
    width:100%; padding:8px 10px; background:var(--inp); border:1px solid var(--bdr);
    border-radius:7px; font-size:13px; color:var(--txt); outline:none;
    transition:border-color .15s, box-shadow .15s; font-family:inherit;
}
.inv-inp:focus, .inv-sel:focus { border-color:var(--ac); box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.inv-inp.danger:focus { border-color:var(--rd); box-shadow:0 0 0 3px rgba(220,38,38,.1); }
.inv-sel { cursor:pointer; }

/* icono‑select de categoría */
.inv-cat-grid {
    display:grid; grid-template-columns:repeat(4,1fr); gap:8px;
}
.inv-cat-opt {
    display:flex; flex-direction:column; align-items:center; gap:4px;
    padding:10px 6px; border-radius:8px; cursor:pointer;
    border:1.5px solid var(--bdr); background:var(--inp);
    transition:border-color .15s, background .15s;
    font-size:11px; font-weight:600; color:var(--sub);
    text-align:center;
}
.inv-cat-opt:hover { border-color:var(--ac); color:var(--txt); }
.inv-cat-opt.on { border-color:var(--ac); background:rgba(37,99,235,.08); color:var(--ac); }
.inv-cat-opt-ico { font-size:20px; line-height:1; }

/* unidad‑select visual */
.inv-unit-grid { display:flex; flex-wrap:wrap; gap:6px; }
.inv-unit-opt {
    padding:6px 14px; border-radius:20px;
    border:1.5px solid var(--bdr); background:var(--inp);
    font-size:12px; font-weight:600; color:var(--sub);
    cursor:pointer; transition:border-color .15s, background .15s, color .15s;
    white-space:nowrap;
}
.inv-unit-opt:hover { border-color:var(--ac); color:var(--txt); }
.inv-unit-opt.on { border-color:var(--ac); background:rgba(37,99,235,.08); color:var(--ac); }

/* stock input group */
.inv-stock-field { position:relative; }
.inv-stock-field input { padding-right:40px; }
.inv-stock-unit-badge {
    position:absolute; right:10px; top:50%; transform:translateY(-50%);
    font-size:11px; font-weight:700; color:var(--sub);
    pointer-events:none;
}

/* progress preview en el form */
.inv-preview-bar {
    margin-top:6px; height:6px; background:var(--bdr);
    border-radius:3px; overflow:hidden;
}
.inv-preview-fill { height:100%; border-radius:3px; transition:width .3s, background .3s; }

/* modal footer */
.inv-mfoot { padding:14px 20px; border-top:1px solid var(--bdr); display:flex; align-items:center; justify-content:flex-end; gap:8px; }
.inv-btn-cancel { padding:8px 16px; border-radius:7px; background:var(--inp); border:1px solid var(--bdr); font-size:13px; font-weight:600; color:var(--sub); cursor:pointer; transition:background .15s; }
.inv-btn-cancel:hover { background:var(--bdr); }
.inv-btn-save { padding:8px 20px; border-radius:7px; background:var(--ac); color:#fff; border:none; font-size:13px; font-weight:600; cursor:pointer; transition:background .15s; display:flex; align-items:center; gap:6px; }
.inv-btn-save:hover { background:var(--ac2); }
.inv-btn-save.gn  { background:var(--gn); }
.inv-btn-save.gn:hover { background:#15803D; }
.inv-btn-save svg { width:14px; height:14px; }

/* ajuste toggle */
.inv-adj-toggle { display:grid; grid-template-columns:1fr 1fr; gap:0; background:var(--inp); border:1px solid var(--bdr); border-radius:8px; padding:3px; }
.inv-adj-opt { padding:8px; border-radius:6px; text-align:center; font-size:13px; font-weight:700; cursor:pointer; transition:background .15s, color .15s; color:var(--sub); }
.inv-adj-opt.add { color:var(--gn); }
.inv-adj-opt.add.on  { background:var(--gn); color:#fff; }
.inv-adj-opt.sub { color:var(--rd); }
.inv-adj-opt.sub.on  { background:var(--rd); color:#fff; }

.inv-big-input {
    width:100%; text-align:center; font-size:36px; font-weight:800;
    background:transparent; border:none; border-bottom:2px solid var(--bdr);
    outline:none; color:var(--txt); padding:4px 40px 8px;
    transition:border-color .15s; font-family:inherit;
    letter-spacing:-1px;
}
.inv-big-input:focus { border-color:var(--ac); }
.inv-big-unit { font-size:13px; font-weight:600; color:var(--sub); text-align:center; margin-top:4px; }

.inv-adj-preview {
    display:flex; align-items:center; justify-content:center; gap:10px;
    padding:10px 14px; border-radius:8px;
    background:var(--inp); border:1px solid var(--bdr);
    font-size:12px; font-weight:600; color:var(--sub);
}
.inv-adj-preview .from { color:var(--sub); }
.inv-adj-preview .arrow { color:var(--bdr); }
.inv-adj-preview .to   { font-size:16px; font-weight:800; color:var(--ac); }
.inv-adj-preview .to.low { color:var(--rd); }
.inv-adj-preview .to.ok  { color:var(--gn); }

@media(max-width:640px){
    .inv { padding:20px 16px 40px; }
    .inv-stats { display:grid; grid-template-columns:1fr 1fr; }
    .inv-g2 { grid-template-columns:1fr; }
    .inv-cat-grid { grid-template-columns:repeat(4,1fr); }
    .inv-overlay { padding:20px 12px 40px; }
}
</style>

<div class="inv" x-data="inventoryManager()" x-init="init()">

    {{-- HEADER --}}
    <div class="inv-hd">
        <div>
            <h1>Inventario de Insumos</h1>
            <p>Controla ingredientes, bebidas y suministros</p>
        </div>
        <button @click="openCreate()" class="inv-btn-add">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Artículo
        </button>
    </div>

    {{-- STATS --}}
    <div class="inv-stats">
        <div class="inv-stat">
            <div class="inv-stat-ico bl">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div><p class="inv-stat-v">{{ $totalItems }}</p><p class="inv-stat-l">Total artículos</p></div>
        </div>
        <div class="inv-stat">
            <div class="inv-stat-ico rd">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div><p class="inv-stat-v" style="color:var(--rd)">{{ $lowStockCount }}</p><p class="inv-stat-l">Stock bajo</p></div>
        </div>
        <div class="inv-stat">
            <div class="inv-stat-ico gn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div><p class="inv-stat-v" style="color:var(--gn)">{{ $totalItems - $lowStockCount }}</p><p class="inv-stat-l">En buen nivel</p></div>
        </div>
        <div class="inv-stat">
            <div class="inv-stat-ico am">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div><p class="inv-stat-v">{{ $items->pluck('category')->unique()->count() }}</p><p class="inv-stat-l">Categorías</p></div>
        </div>
    </div>

    {{-- SEARCH + FILTROS --}}
    <div class="inv-bar">
        <div class="inv-search">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            <input type="text" x-model="search" placeholder="Buscar artículo...">
        </div>
        <button @click="catFilter='todos'" :class="catFilter==='todos'?'on':''" class="inv-filter-btn">Todos</button>
        <button @click="catFilter='low'" :class="catFilter==='low'?'rd-on':''" class="inv-filter-btn" style="color:var(--rd)">
            ⚠ Stock bajo
        </button>
        <template x-for="cat in categorias" :key="cat.val">
            <button @click="catFilter=cat.val" :class="catFilter===cat.val?'on':''" class="inv-filter-btn">
                <span x-text="cat.ico + ' ' + cat.label"></span>
            </button>
        </template>
    </div>

    {{-- TABLE --}}
    <div class="inv-card">
        <div class="inv-card-hd">
            <div class="inv-card-ttl">
                <div class="inv-card-ttl-ico">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <span>Artículos</span>
            </div>
            <span class="inv-badge" x-text="visibleCount() + ' registros'"></span>
        </div>

        <div class="inv-table-wrap">
            <table class="inv-table">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Categoría</th>
                        <th style="text-align:center">Stock actual</th>
                        <th style="text-align:center">Mínimo</th>
                        <th style="text-align:center">Nivel</th>
                        <th style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    @php
                        $ratio = $item->min_stock > 0 ? $item->current_stock / $item->min_stock : 2;
                        $level = $ratio <= 1 ? 'low' : ($ratio <= 1.5 ? 'mid' : 'ok');
                        $catInfo = collect([
                            ['val'=>'Carnes',     'ico'=>'🥩', 'label'=>'Carnes'],
                            ['val'=>'Mariscos',   'ico'=>'🦐', 'label'=>'Mariscos'],
                            ['val'=>'Verduras',   'ico'=>'🍅', 'label'=>'Verduras'],
                            ['val'=>'Frutas',     'ico'=>'🥭', 'label'=>'Frutas'],
                            ['val'=>'Bebidas',    'ico'=>'🥤', 'label'=>'Bebidas'],
                            ['val'=>'Alcohol',    'ico'=>'🥃', 'label'=>'Alcohol'],
                            ['val'=>'Insumos Bar','ico'=>'🍹', 'label'=>'Insumos Bar'],
                            ['val'=>'Lácteos',    'ico'=>'🧀', 'label'=>'Lácteos'],
                            ['val'=>'Panadería',  'ico'=>'🍞', 'label'=>'Panadería'],
                            ['val'=>'Dulces',     'ico'=>'🍪', 'label'=>'Dulces'],
                            ['val'=>'Abarrotes',  'ico'=>'🥫', 'label'=>'Abarrotes'],
                            ['val'=>'Salsas',     'ico'=>'🌶️', 'label'=>'Salsas'],
                            ['val'=>'Limpieza',   'ico'=>'🧼', 'label'=>'Limpieza'],
                            ['val'=>'Postres',    'ico'=>'🍰', 'label'=>'Postres'],
                            ['val'=>'Otros',      'ico'=>'📦', 'label'=>'Otros'],
                        ])->firstWhere('val', $item->category);
                        $catIco = $catInfo ? $catInfo['ico'] : '📦';
                        $pct = min(100, max(4, $ratio >= 2 ? 100 : intval($ratio * 50)));
                    @endphp
                    <tr x-show="rowVisible('{{ $item->category }}', {{ $item->current_stock <= $item->min_stock ? 'true' : 'false' }}, '{{ addslashes($item->name) }}')"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <td>
                            <p class="inv-name">{{ $item->name }}</p>
                            <p class="inv-id">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </td>
                        <td>
                            <span class="inv-cat-chip">
                                <span>{{ $catIco }}</span>
                                {{ $item->category }}
                            </span>
                        </td>
                        <td style="text-align:center">
                            <span class="inv-stock {{ $level }}">
                                @if($level === 'low')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/></svg>
                                @elseif($level === 'mid')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                                @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @endif
                                {{ floatval($item->current_stock) }}
                                <span class="inv-stock-unit">{{ $item->unit }}</span>
                            </span>
                        </td>
                        <td style="text-align:center; font-size:12px; font-weight:600; color:var(--sub)">
                            {{ floatval($item->min_stock) }} <span style="font-size:10px;font-weight:700;">{{ $item->unit }}</span>
                        </td>
                        <td style="text-align:center">
                            <div class="inv-progress" style="margin:0 auto">
                                <div class="inv-progress-fill {{ $level }}" style="width:{{ $pct }}%"></div>
                            </div>
                        </td>
                        <td>
                            <div class="inv-actions">
                                <button class="inv-act adj" title="Ajustar stock"
                                        @click="openAdjust({{ json_encode($item) }})">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                </button>
                                <button class="inv-act ed" title="Editar"
                                        @click="openEdit({{ json_encode($item) }})">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST"
                                      @submit.prevent="confirmDelete($el)">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inv-act dl" title="Eliminar">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="inv-empty">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <p>No hay artículos en el inventario aún.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         MODAL 1 — CREAR / EDITAR
    ════════════════════════════════════════ --}}
    <div x-show="openModal" x-cloak class="inv-overlay" @click.self="openModal=false">
        <div class="inv-modal" @click.stop>

            <div class="inv-mhd">
                <div>
                    <h3 x-text="isEdit ? 'Editar Artículo' : 'Nuevo Artículo'"></h3>
                    <p x-text="isEdit ? 'Modifica los datos del artículo' : 'Completa la información del nuevo insumo'"></p>
                </div>
                <button @click="openModal=false" class="inv-mclose">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="actionUrl" method="POST">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="inv-mbody">

                    {{-- Nombre --}}
                    <div>
                        <label class="inv-lbl">Nombre del artículo <span class="req">*</span></label>
                        <input type="text" name="name" class="inv-inp"
                               x-model="formData.name"
                               placeholder="Ej: Tomate Guaje, Cerveza Corona, Carne Molida..."
                               required>
                    </div>

                    {{-- Categoría visual --}}
                    <div>
                        <p class="inv-sec">Categoría</p>
                        <div class="inv-cat-grid" style="margin-top:10px">
                            <template x-for="cat in categorias" :key="cat.val">
                                <div class="inv-cat-opt"
                                     :class="formData.category === cat.val ? 'on' : ''"
                                     @click="formData.category = cat.val">
                                    <span class="inv-cat-opt-ico" x-text="cat.ico"></span>
                                    <span x-text="cat.label"></span>
                                </div>
                            </template>
                        </div>
                        {{-- hidden para el form --}}
                        <input type="hidden" name="category" :value="formData.category">
                    </div>

                    {{-- Unidad de medida visual --}}
                    <div>
                        <p class="inv-sec">Unidad de medida</p>
                        <div class="inv-unit-grid" style="margin-top:10px">
                            <template x-for="u in unidades" :key="u.val">
                                <div class="inv-unit-opt"
                                     :class="formData.unit === u.val ? 'on' : ''"
                                     @click="formData.unit = u.val"
                                     x-text="u.label">
                                </div>
                            </template>
                        </div>
                        <input type="hidden" name="unit" :value="formData.unit">
                    </div>

                    {{-- Stock inicial + mínimo --}}
                    <div>
                        <p class="inv-sec">Niveles de stock</p>
                        <div class="inv-g2" style="margin-top:10px">
                            <div>
                                <label class="inv-lbl">Stock <span x-text="isEdit ? 'actual' : 'inicial'"></span> <span class="req">*</span></label>
                                <div class="inv-stock-field">
                                    <input type="number" step="0.01" min="0" name="current_stock"
                                           class="inv-inp" x-model="formData.current_stock"
                                           placeholder="0.00" required>
                                    <span class="inv-stock-unit-badge" x-text="formData.unit"></span>
                                </div>
                            </div>
                            <div>
                                <label class="inv-lbl" style="color:var(--rd)">Alerta mínima <span class="req">*</span></label>
                                <div class="inv-stock-field">
                                    <input type="number" step="0.01" min="0" name="min_stock"
                                           class="inv-inp danger" x-model="formData.min_stock"
                                           placeholder="0.00" required>
                                    <span class="inv-stock-unit-badge" x-text="formData.unit"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Preview visual del nivel --}}
                        <div style="margin-top:12px; padding:12px; border-radius:8px; background:var(--inp); border:1px solid var(--bdr);">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <span style="font-size:11px; font-weight:600; color:var(--sub);">Vista previa del nivel</span>
                                <span style="font-size:11px; font-weight:700;" :style="'color:' + previewColor()" x-text="previewLabel()"></span>
                            </div>
                            <div class="inv-preview-bar">
                                <div class="inv-preview-fill"
                                     :style="'width:' + previewPct() + '%; background:' + previewColor()"></div>
                            </div>
                            <div style="display:flex; justify-content:space-between; margin-top:4px;">
                                <span style="font-size:10px; color:var(--sub)">0</span>
                                <span style="font-size:10px; color:var(--sub)" x-text="'Mínimo: ' + (formData.min_stock || 0) + ' ' + formData.unit"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="inv-mfoot">
                    <button type="button" @click="openModal=false" class="inv-btn-cancel">Cancelar</button>
                    <button type="submit" class="inv-btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Artículo'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         MODAL 2 — AJUSTE RÁPIDO DE STOCK
    ════════════════════════════════════════ --}}
    <div x-show="openAdjustModal" x-cloak class="inv-overlay" style="z-index:60" @click.self="openAdjustModal=false">
        <div class="inv-modal sm" @click.stop>

            <div class="inv-mhd">
                <div>
                    <h3>Ajustar Stock</h3>
                    <p x-text="adjItemName"></p>
                </div>
                <button @click="openAdjustModal=false" class="inv-mclose">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="adjustUrl" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="inv-mbody">

                    {{-- Toggle Entró / Salió --}}
                    <div class="inv-adj-toggle">
                        <div class="inv-adj-opt add" :class="adjType==='add'?'on':''"
                             @click="adjType='add'">
                            ↑ Entró
                        </div>
                        <div class="inv-adj-opt sub" :class="adjType==='subtract'?'on':''"
                             @click="adjType='subtract'">
                            ↓ Salió
                        </div>
                    </div>
                    <input type="hidden" name="type" :value="adjType">

                    {{-- Cantidad --}}
                    <div style="text-align:center; padding:10px 0">
                        <label class="inv-lbl" style="text-align:center; display:block; margin-bottom:10px;">Cantidad a ajustar</label>
                        <div style="position:relative; display:inline-block; width:100%;">
                            <input type="number" step="0.01" min="0.01" name="amount"
                                   class="inv-big-input"
                                   x-model="adjAmount"
                                   placeholder="0"
                                   required>
                        </div>
                        <p class="inv-big-unit" x-text="adjItemUnit"></p>
                    </div>

                    {{-- Preview resultado --}}
                    <div class="inv-adj-preview">
                        <span class="from" x-text="adjCurrentStock + ' ' + adjItemUnit"></span>
                        <span class="arrow">→</span>
                        <span class="to"
                              :class="adjResultClass()"
                              x-text="adjResult() + ' ' + adjItemUnit">
                        </span>
                    </div>

                </div>

                <div class="inv-mfoot">
                    <button type="button" @click="openAdjustModal=false" class="inv-btn-cancel">Cancelar</button>
                    <button type="submit" class="inv-btn-save gn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Actualizar Stock
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function inventoryManager() {
    return {
        search:    '',
        catFilter: 'todos',

        categorias: [
            { val:'Carnes',      ico:'🥩', label:'Carnes'      },
            { val:'Mariscos',    ico:'🦐', label:'Mariscos'    },
            { val:'Verduras',    ico:'🍅', label:'Verduras'    },
            { val:'Frutas',      ico:'🥭', label:'Frutas'      },
            { val:'Bebidas',     ico:'🥤', label:'Bebidas'     },
            { val:'Alcohol',     ico:'🥃', label:'Alcohol'     },
            { val:'Insumos Bar', ico:'🍹', label:'Insumos Bar' },
            { val:'Lácteos',     ico:'🧀', label:'Lácteos'     },
            { val:'Panadería',   ico:'🍞', label:'Panadería'   },
            { val:'Dulces',      ico:'🍪', label:'Dulces'      },
            { val:'Abarrotes',   ico:'🥫', label:'Abarrotes'   },
            { val:'Salsas',      ico:'🌶️', label:'Salsas'      },
            { val:'Limpieza',    ico:'🧼', label:'Limpieza'    },
            { val:'Postres',     ico:'🍰', label:'Postres'     },
            { val:'Otros',       ico:'📦', label:'Otros'       },
        ],

        unidades: [
            { val:'kg',       label:'kg — Kilogramos' },
            { val:'L',        label:'L — Litros'      },
            { val:'pz',       label:'pz — Piezas'     },
            { val:'g',        label:'g — Gramos'      },
            { val:'ml',       label:'ml — Mililitros' },
            { val:'cajas',    label:'Cajas'           },
            { val:'paquetes', label:'Paquetes'        },
        ],

        rowVisible(cat, isLow, name) {
            const matchSearch = !this.search || name.toLowerCase().includes(this.search.toLowerCase());
            const matchCat    = this.catFilter === 'todos'
                             || (this.catFilter === 'low' && isLow)
                             || this.catFilter === cat;
            return matchSearch && matchCat;
        },

        visibleCount() {
            return document.querySelectorAll('.inv-table tbody tr[style=""],.inv-table tbody tr:not([style])').length;
        },

        openModal: false,
        isEdit:    false,
        actionUrl: '',
        formData: { name:'', category:'Carnes', unit:'kg', current_stock:'', min_stock:'' },

        init() {},

        openCreate() {
            this.isEdit    = false;
            this.actionUrl = '{{ route("admin.inventory.store") }}';
            this.formData  = { name:'', category:'Carnes', unit:'kg', current_stock:'', min_stock:'' };
            this.openModal = true;
        },

        openEdit(item) {
            this.isEdit    = true;
            this.actionUrl = '{{ route("admin.inventory.update", ":id") }}'.replace(':id', item.id);
            this.formData  = { name:item.name, category:item.category, unit:item.unit, current_stock:item.current_stock, min_stock:item.min_stock };
            this.openModal = true;
        },

        /* Preview del nivel de stock en el formulario */
        previewPct() {
            const cur = parseFloat(this.formData.current_stock) || 0;
            const min = parseFloat(this.formData.min_stock)     || 0;
            if (min === 0) return cur > 0 ? 100 : 0;
            return Math.min(100, Math.max(4, Math.round((cur / (min * 2)) * 100)));
        },
        previewColor() {
            const cur = parseFloat(this.formData.current_stock) || 0;
            const min = parseFloat(this.formData.min_stock)     || 0;
            if (min === 0) return '#71717A';
            const r = cur / min;
            if (r <= 1)   return '#DC2626';
            if (r <= 1.5) return '#D97706';
            return '#16A34A';
        },
        previewLabel() {
            const cur = parseFloat(this.formData.current_stock) || 0;
            const min = parseFloat(this.formData.min_stock)     || 0;
            if (min === 0 || cur === 0) return '—';
            const r = cur / min;
            if (r <= 1)   return '⚠ Stock bajo';
            if (r <= 1.5) return '~ Nivel medio';
            return '✓ Nivel óptimo';
        },

        /* ── Modal ajuste rápido ── */
        openAdjustModal: false,
        adjustUrl:       '',
        adjItemName:     '',
        adjItemUnit:     '',
        adjCurrentStock: 0,
        adjMinStock:     0,
        adjType:         'add',
        adjAmount:       '',

        openAdjust(item) {
            this.adjustUrl       = '{{ route("admin.inventory.adjust", ":id") }}'.replace(':id', item.id);
            this.adjItemName     = item.name;
            this.adjItemUnit     = item.unit;
            this.adjCurrentStock = parseFloat(item.current_stock);
            this.adjMinStock     = parseFloat(item.min_stock);
            this.adjType         = 'add';
            this.adjAmount       = '';
            this.openAdjustModal = true;
        },

        adjResult() {
            const amt = parseFloat(this.adjAmount) || 0;
            const res = this.adjType === 'add'
                ? this.adjCurrentStock + amt
                : Math.max(0, this.adjCurrentStock - amt);
            return Math.round(res * 100) / 100;
        },

        adjResultClass() {
            const res = this.adjResult();
            if (res <= this.adjMinStock) return 'low';
            if (res <= this.adjMinStock * 1.5) return '';
            return 'ok';
        },

        /* ── Eliminar ── */
        confirmDelete(form) {
            if (confirm('¿Eliminar este artículo del inventario?\nEsta acción no se puede deshacer.')) {
                form.submit();
            }
        },
    }
}
</script>

@endsection