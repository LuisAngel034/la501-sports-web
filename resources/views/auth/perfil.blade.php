@extends('layouts.app')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;600;700&family=Inter:wght@400;500&display=swap');

/* ══════════════════════════════════════════
   VARIABLES
══════════════════════════════════════════ */
.pf {
    --or:  #F97316; --or2: #EA580C;
    --gn:  #16A34A; --gn2: #22C55E;
    --bg:      #0A0A0A; --card:  #141414;
    --inp:     #1C1C1C; --txt:   #FFFFFF;
    --sub:     #A1A1AA; --bdr:   rgba(255,255,255,.07);
    --glow:    rgba(249,115,22,.12);
    --hex: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15L13.99 9.25z'/%3E%3C/g%3E%3C/svg%3E");
}
html:not(.dark) .pf {
    --bg:   #F5F3EF; --card:  #FFFFFF;
    --inp:  #F4F4F5; --txt:   #18181B;
    --sub:  #71717A; --bdr:   rgba(0,0,0,.09);
    --glow: rgba(249,115,22,.08);
    --hex: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23000000' fill-opacity='0.025'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15L13.99 9.25z'/%3E%3C/g%3E%3C/svg%3E");
}

.pf { background:var(--bg); color:var(--txt); font-family:'Inter',sans-serif; min-height:100vh; padding:40px 24px 80px; transition:background .3s,color .3s; }

/* WRAP */
.pf-wrap { max-width:1000px; margin:0 auto; display:flex; flex-direction:column; gap:20px; }

/* ── TOP GRID ── */
.pf-top { display:grid; grid-template-columns:260px 1fr; gap:20px; align-items:start; }
@media(max-width:720px){ .pf-top { grid-template-columns:1fr; } }

/* ── CARD BASE ── */
.pf-card {
    background:var(--card); background-image:var(--hex);
    border:1px solid var(--bdr); border-radius:12px;
    overflow:hidden; transition:background .3s,border-color .3s;
}
.pf-card-top { height:3px; }
.pf-card-top.or { background:linear-gradient(90deg,var(--or),var(--gn)); }
.pf-card-top.gn { background:linear-gradient(90deg,var(--gn),var(--gn2)); }
.pf-card-top.am { background:linear-gradient(90deg,#D97706,#F59E0B); }
.pf-card-body { padding:20px; }

/* ── AVATAR CARD ── */
.pf-avatar-card { text-align:center; }
.pf-avatar-wrap {
    position:relative; width:96px; height:96px;
    margin:0 auto 14px; cursor:pointer;
}
.pf-avatar-wrap img,
.pf-avatar-ph {
    width:100%; height:100%; border-radius:50%; object-fit:cover;
    border:3px solid var(--or);
    box-shadow:0 0 0 4px rgba(249,115,22,.15);
    transition:opacity .2s;
}
.pf-avatar-ph {
    background:linear-gradient(135deg,var(--or),var(--or2));
    display:flex; align-items:center; justify-content:center;
    font-size:32px; font-weight:700; color:#fff;
    font-family:'Oswald',sans-serif;
}
.pf-avatar-ovl {
    position:absolute; inset:0; border-radius:50%;
    background:rgba(0,0,0,.55);
    display:flex; align-items:center; justify-content:center;
    opacity:0; transition:opacity .2s;
}
.pf-avatar-wrap:hover .pf-avatar-ovl { opacity:1; }
.pf-avatar-wrap:hover img,
.pf-avatar-wrap:hover .pf-avatar-ph { opacity:.7; }
.pf-avatar-ovl span { font-size:10px; font-weight:700; color:#fff; letter-spacing:.5px; text-transform:uppercase; }

.pf-name { font-family:'Oswald',sans-serif; font-size:20px; font-weight:700; color:var(--txt); margin:0 0 3px; letter-spacing:.5px; transition:color .3s; }
.pf-role { display:inline-block; font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; background:rgba(249,115,22,.1); border:1px solid rgba(249,115,22,.2); color:var(--or); padding:2px 10px; border-radius:20px; margin-bottom:10px; }
.pf-since { font-size:11px; color:var(--sub); }

/* separador */
.pf-sep { height:1px; background:var(--bdr); margin:14px 0; }

/* mini stats en avatar card */
.pf-mini-stats { display:flex; gap:0; }
.pf-mini-stat { flex:1; padding:8px 4px; text-align:center; }
.pf-mini-stat:not(:last-child) { border-right:1px solid var(--bdr); }
.pf-mini-stat-v { font-size:16px; font-weight:800; color:var(--txt); margin:0; line-height:1; transition:color .3s; }
.pf-mini-stat-l { font-size:9px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); margin-top:2px; }

/* ── RIGHT SIDE ── */
.pf-right { display:flex; flex-direction:column; gap:16px; }

/* stats row */
.pf-stats { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.pf-stat {
    background:var(--card); background-image:var(--hex);
    border:1px solid var(--bdr); border-radius:10px;
    padding:14px 16px; display:flex; align-items:center; gap:10px;
    transition:background .3s,border-color .3s;
}
.pf-stat:hover { border-color:var(--or); }
.pf-stat-ico { font-size:24px; flex-shrink:0; }
.pf-stat-v { font-size:22px; font-weight:800; color:var(--txt); margin:0; line-height:1; letter-spacing:-.5px; transition:color .3s; }
.pf-stat-l { font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); }
.pf-stat-v.or { color:var(--or); }
.pf-stat-v.gn { color:var(--gn); }

/* form fields */
.pf-lbl { display:block; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); margin-bottom:5px; }
.pf-inp, .pf-ro {
    width:100%; padding:9px 12px;
    background:var(--inp); border:1.5px solid var(--bdr);
    border-radius:8px; font-size:13px; color:var(--txt);
    outline:none; font-family:inherit;
    transition:border-color .15s,box-shadow .15s,background .3s;
}
.pf-inp:focus { border-color:var(--or); box-shadow:0 0 0 3px rgba(249,115,22,.1); }
.pf-ro { cursor:not-allowed; opacity:.6; }
.pf-ro-note { font-size:10px; color:var(--sub); margin:4px 0 0; }
.pf-g2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
@media(max-width:500px){ .pf-g2 { grid-template-columns:1fr; } }

/* submit btn */
.pf-submit {
    padding:10px 24px; background:var(--or); color:#fff;
    border:none; border-radius:8px; font-size:13px; font-weight:700;
    cursor:pointer; font-family:inherit;
    display:inline-flex; align-items:center; gap:6px;
    box-shadow:0 2px 10px rgba(249,115,22,.3);
    transition:background .15s,transform .1s; margin-top:14px;
}
.pf-submit:hover  { background:var(--or2); }
.pf-submit:active { transform:scale(.98); }
.pf-submit svg { width:14px; height:14px; }

/* alert */
.pf-alert-ok { display:flex; align-items:center; gap:8px; padding:9px 12px; border-radius:7px; margin-bottom:14px; background:rgba(22,163,74,.07); border:1px solid rgba(22,163,74,.2); font-size:12px; font-weight:600; color:var(--gn); }
.pf-alert-ok svg { width:13px; height:13px; flex-shrink:0; }

/* ── LOGROS ── */
.pf-logros-header { display:flex; align-items:baseline; justify-content:space-between; margin-bottom:16px; }
.pf-logros-ttl { font-family:'Oswald',sans-serif; font-size:18px; font-weight:700; letter-spacing:.5px; color:var(--txt); margin:0; transition:color .3s; }
.pf-logros-count { font-size:11px; color:var(--sub); }
.pf-logros-count strong { color:var(--or); }

.pf-cat-label {
    display:flex; align-items:center; gap:8px;
    font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--sub);
    margin:18px 0 10px;
}
.pf-cat-label::after { content:''; flex:1; height:1px; background:var(--bdr); }

.pf-logros-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); gap:10px; }

/* badge desbloqueado */
.pf-badge {
    position:relative; display:flex; flex-direction:column; align-items:center;
    text-align:center; padding:14px 10px 12px;
    background:var(--inp); border:1.5px solid var(--bdr);
    border-radius:10px; transition:border-color .2s,background .2s,transform .2s;
    overflow:hidden;
}
.pf-badge::before {
    content:''; position:absolute; inset:0;
    background:radial-gradient(ellipse at top, rgba(249,115,22,.06) 0%, transparent 70%);
    opacity:0; transition:opacity .2s;
}
.pf-badge:hover { border-color:var(--or); transform:translateY(-3px); }
.pf-badge:hover::before { opacity:1; }
.pf-badge-ico { font-size:28px; margin-bottom:8px; position:relative; z-index:1; }
.pf-badge-name { font-size:11px; font-weight:700; color:var(--txt); margin:0 0 3px; line-height:1.3; position:relative; z-index:1; transition:color .3s; }
.pf-badge-date { font-size:9px; color:var(--or); font-weight:600; position:relative; z-index:1; }

/* shine effect on unlocked badge */
.pf-badge-shine {
    position:absolute; top:0; left:-100%;
    width:60%; height:100%;
    background:linear-gradient(90deg, transparent, rgba(255,255,255,.06), transparent);
    transition:left .4s;
}
.pf-badge:hover .pf-badge-shine { left:150%; }

/* empty state logros */
.pf-logros-empty { text-align:center; padding:32px 20px; }
.pf-logros-empty p { font-size:13px; color:var(--sub); margin:0; }

@media(max-width:560px){
    .pf { padding:24px 14px 60px; }
    .pf-logros-grid { grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); }
}
</style>

<div class="pf">
<div class="pf-wrap">

    {{-- ── TOP: avatar + form ── --}}
    <div class="pf-top">

        {{-- AVATAR CARD --}}
        <div class="pf-card pf-avatar-card">
            <div class="pf-card-top or"></div>
            <div class="pf-card-body">

                <div class="pf-avatar-wrap" onclick="document.getElementById('avatar-input').click()">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" id="avatar-preview" alt="{{ $user->name }}">
                    @else
                        <div class="pf-avatar-ph" id="avatar-placeholder">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="pf-avatar-ovl"><span>Cambiar</span></div>
                </div>

                <p class="pf-name">{{ $user->name }}</p>
                <span class="pf-role">{{ ucfirst($user->role) }}</span>
                <p class="pf-since">Miembro desde {{ $user->created_at->format('M Y') }}</p>

                <div class="pf-sep"></div>

                <div class="pf-mini-stats">
                    <div class="pf-mini-stat">
                        <p class="pf-mini-stat-v" style="color:var(--or)">{{ $user->points ?? 0 }}</p>
                        <p class="pf-mini-stat-l">Puntos</p>
                    </div>
                    <div class="pf-mini-stat">
                        <p class="pf-mini-stat-v" style="color:var(--gn)">{{ count($unlockedIds) }}</p>
                        <p class="pf-mini-stat-l">Logros</p>
                    </div>
                    <div class="pf-mini-stat">
                        <p class="pf-mini-stat-v">{{ $reservacionesTotales }}</p>
                        <p class="pf-mini-stat-l">Reservas</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM ── --}}
        <div class="pf-right">

            <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">

                <div class="pf-card">
                    <div class="pf-card-top gn"></div>
                    <div class="pf-card-body">

                        @if(session('status'))
                        <div class="pf-alert-ok">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('status') }}
                        </div>
                        @endif

                        <div style="font-family:'Oswald',sans-serif;font-size:14px;font-weight:700;letter-spacing:.5px;color:var(--txt);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                            <svg style="width:14px;height:14px;color:var(--gn);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Información de Contacto
                        </div>

                        <div class="pf-g2">
                            <div>
                                <label class="pf-lbl">Correo electrónico</label>
                                <input type="text" class="pf-ro" value="{{ $user->email }}" readonly>
                                <p class="pf-ro-note">Dato de seguridad (no editable)</p>
                            </div>
                            <div>
                                <label class="pf-lbl">Teléfono</label>
                                <input type="text" name="telefono" class="pf-inp" value="{{ $user->telefono }}" placeholder="614 000 0000">
                            </div>
                        </div>

                        <button type="submit" class="pf-submit">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>

            {{-- STATS ── --}}
            <div class="pf-stats">
                <div class="pf-stat">
                    <span class="pf-stat-ico">🏆</span>
                    <div>
                        <p class="pf-stat-v or">{{ $user->points ?? 0 }}</p>
                        <p class="pf-stat-l">Puntos La 501</p>
                    </div>
                </div>
                <div class="pf-stat">
                    <span class="pf-stat-ico">📅</span>
                    <div>
                        <p class="pf-stat-v gn">{{ $reservacionesTotales }}</p>
                        <p class="pf-stat-l">Reservaciones</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ── LOGROS ── --}}
    <div class="pf-card">
        <div class="pf-card-top am"></div>
        <div class="pf-card-body">

            <div class="pf-logros-header">
                <h2 class="pf-logros-ttl">🏅 Mis Logros</h2>
                <span class="pf-logros-count">
                    <strong>{{ count($unlockedIds) }}</strong> / {{ $allAchievements->count() }} desbloqueados
                </span>
            </div>

            @php
                $categorias = [
                    'compras'       => ['label' => 'Compras',       'ico' => '🛒'],
                    'reservaciones' => ['label' => 'Reservaciones', 'ico' => '📅'],
                    'fidelidad'     => ['label' => 'Fidelidad',     'ico' => '❤️'],
                    'variedad'      => ['label' => 'Variedad',      'ico' => '🍽️'],
                    'especial'      => ['label' => 'Especial',      'ico' => '⭐'],
                ];

                // Solo mostrar categorías que tengan al menos 1 logro desbloqueado
                $hayLogros = false;
                foreach($categorias as $cat => $meta) {
                    $grupo = $allAchievements->where('categoria', $cat);
                    foreach($grupo as $logro) {
                        if(in_array($logro->id, $unlockedIds)) { $hayLogros = true; break 2; }
                    }
                }
            @endphp

            @if(!$hayLogros)
            <div class="pf-logros-empty">
                <p style="font-size:32px;margin-bottom:8px;">🔒</p>
                <p>Aún no has desbloqueado ningún logro.</p>
                <p style="font-size:12px;color:var(--sub);margin-top:4px;">Realiza pedidos, haz reservaciones y sigue visitándonos para ganarlos.</p>
            </div>
            @else
                @foreach($categorias as $cat => $meta)
                @php
                    $grupo = $allAchievements->where('categoria', $cat);
                    $desbloqueadosEnCat = $grupo->filter(fn($l) => in_array($l->id, $unlockedIds));
                @endphp
                @if($desbloqueadosEnCat->count() > 0)
                <p class="pf-cat-label">{{ $meta['ico'] }} {{ $meta['label'] }}</p>
                <div class="pf-logros-grid">
                    @foreach($desbloqueadosEnCat as $logro)
                    @php
                        $pivotRow = $user->achievements()
                                        ->where('achievement_id', $logro->id)
                                        ->first();
                    @endphp
                    <div class="pf-badge">
                        <div class="pf-badge-shine"></div>
                        <span class="pf-badge-ico">{{ $logro->icono }}</span>
                        <p class="pf-badge-name">{{ $logro->nombre }}</p>
                        <p class="pf-badge-date">
                            {{ $pivotRow?->pivot->unlocked_at
                                ? \Carbon\Carbon::parse($pivotRow->pivot->unlocked_at)->format('d M Y')
                                : '' }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @endif
                @endforeach
            @endif

        </div>
    </div>

</div>
</div>

<script>
function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        let img = document.getElementById('avatar-preview');
        if (img) {
            img.src = e.target.result;
        } else {
            const ph = document.getElementById('avatar-placeholder');
            if (ph) ph.style.display = 'none';
            const newImg = document.createElement('img');
            newImg.id = 'avatar-preview';
            newImg.src = e.target.result;
            newImg.style.cssText = 'width:100%;height:100%;border-radius:50%;object-fit:cover;border:3px solid var(--or)';
            document.querySelector('.pf-avatar-wrap').prepend(newImg);
        }
    };
    reader.readAsDataURL(input.files[0]);
}
</script>

@endsection
