@extends('layouts.app')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;600;700&family=Inter:wght@400;500&display=swap');

/* ══════════════════════════════════════════════
   VARIABLES — sistema público La 501
══════════════════════════════════════════════ */
.ct-page {
    --or:  #F97316; --or2: #EA580C;
    --gn:  #16A34A; --gn2: #22C55E;
    --bg:      #0A0A0A;
    --card:    #141414;
    --inp:     #1C1C1C;
    --txt:     #FFFFFF;
    --sub:     #A1A1AA;
    --bdr:     rgba(255,255,255,.07);
    --glow:    rgba(249,115,22,.18);
    --hex: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15L13.99 9.25z'/%3E%3C/g%3E%3C/svg%3E");
}
html:not(.dark) .ct-page {
    --bg:   #F5F3EF; --card: #FFFFFF;
    --inp:  #F4F4F5; --txt:  #18181B;
    --sub:  #71717A; --bdr:  rgba(0,0,0,.09);
    --glow: rgba(249,115,22,.10);
    --hex: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49'%3E%3Cg fill='%23000000' fill-opacity='0.025'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15L13.99 9.25z'/%3E%3C/g%3E%3C/svg%3E");
}

.ct-page {
    background: var(--bg);
    color: var(--txt);
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    transition: background .3s, color .3s;
}

/* ── HERO ──────────────────────────────────── */
.ct-hero {
    position: relative;
    background: var(--card);
    background-image: var(--hex);
    border-bottom: 3px solid var(--or);
    padding: 64px 32px 56px;
    text-align: center;
    overflow: hidden;
    transition: background .3s;
}
.ct-hero::before {
    content: '';
    position: absolute;
    top: -80px; left: 50%; transform: translateX(-50%);
    width: 600px; height: 300px;
    background: radial-gradient(ellipse, var(--glow) 0%, transparent 70%);
    pointer-events: none;
}
.ct-hero-badge {
    display: inline-block;
    background: var(--or); color: #fff;
    font-family: 'Oswald', sans-serif;
    font-size: 10px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    padding: 5px 18px;
    clip-path: polygon(10px 0%,100% 0%,calc(100% - 10px) 100%,0% 100%);
    margin-bottom: 20px;
}
.ct-hero h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(52px, 10vw, 90px);
    letter-spacing: 5px; line-height: .95;
    color: var(--txt); margin: 0 0 16px;
    position: relative; z-index: 1;
    transition: color .3s;
}
.ct-hero h1 span { color: var(--or); }
.ct-hero p {
    font-size: 16px; color: var(--sub);
    max-width: 480px; margin: 0 auto;
    line-height: 1.75; position: relative; z-index: 1;
    transition: color .3s;
}

/* ── LAYOUT ────────────────────────────────── */
.ct-wrap {
    max-width: 750px;
    width: 100%;
    margin: 0 auto;
    padding: 60px 20px 80px;
}

@media(max-width:860px){
    .ct-sidebar { order: -1; }
}

/* ── FORM CARD ─────────────────────────────── */
.ct-card {
    background: var(--card);
    background-image: var(--hex);
    border: 1px solid var(--bdr);
    border-radius: 16px;
    overflow: hidden;
    transition: background .3s, border-color .3s;
}
.ct-card-top { height: 4px; background: linear-gradient(90deg, var(--or), var(--gn)); }
.ct-card-body { padding: 28px 32px 32px; }
@media(max-width:560px){ .ct-card-body { padding: 20px 20px 24px; } }

.ct-card-ttl {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 6px;
}
.ct-card-ttl-ico {
    width: 32px; height: 32px; border-radius: 8px;
    background: rgba(249,115,22,.12); border: 1px solid rgba(249,115,22,.2);
    display: flex; align-items: center; justify-content: center;
}
.ct-card-ttl-ico svg { width: 15px; height: 15px; color: var(--or); }
.ct-card-ttl h2 { font-family:'Oswald',sans-serif; font-size:18px; font-weight:700; letter-spacing:1px; color:var(--txt); margin:0; transition:color .3s; }
.ct-card-sub { font-size:13px; color:var(--sub); margin:0 0 24px; line-height:1.5; transition:color .3s; }

/* alerts */
.ct-alert {
    display: flex; align-items: flex-start; gap: 8px;
    padding: 10px 14px; border-radius: 8px; margin-bottom: 20px;
}
.ct-alert.ok  { background:rgba(22,163,74,.07);  border:1px solid rgba(22,163,74,.2);  }
.ct-alert.err { background:rgba(220,38,38,.07);  border:1px solid rgba(220,38,38,.2);  }
.ct-alert svg { width:14px; height:14px; flex-shrink:0; margin-top:1px; }
.ct-alert.ok  svg, .ct-alert.ok  p { color: var(--gn); }
.ct-alert.err svg, .ct-alert.err p { color: #DC2626; }
.ct-alert p { font-size:12px; font-weight:500; margin:0; line-height:1.5; }

/* form fields */
.ct-form { display:flex; flex-direction:column; gap:16px; }
.ct-g2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
@media(max-width:560px){ .ct-g2 { grid-template-columns:1fr; } }
.ct-lbl { display:block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); margin-bottom:5px; }
.ct-lbl .req { color: var(--or); }
.ct-inp, .ct-sel, .ct-ta {
    width:100%; padding:10px 12px;
    background:var(--inp); border:1.5px solid var(--bdr);
    border-radius:8px; font-size:13px; color:var(--txt);
    outline:none; transition:border-color .15s,box-shadow .15s,background .3s;
    font-family:inherit;
}
.ct-inp:focus, .ct-sel:focus, .ct-ta:focus {
    border-color:var(--or); box-shadow:0 0 0 3px rgba(249,115,22,.12);
}
.ct-sel { cursor:pointer; }
.ct-ta  { resize:vertical; min-height:110px; }

/* tipo de mensaje — pills visuales */
.ct-type-grid { display:flex; gap:8px; flex-wrap:wrap; }
.ct-type-opt {
    flex:1; min-width:100px;
    padding:8px 10px; border-radius:8px; cursor:pointer;
    border:1.5px solid var(--bdr); background:var(--inp);
    font-size:12px; font-weight:600; color:var(--sub);
    text-align:center; transition:border-color .15s,background .15s,color .15s;
    display:flex; flex-direction:column; align-items:center; gap:4px;
}
.ct-type-opt span.ico { font-size:18px; }
.ct-type-opt:hover { border-color: var(--or); color:var(--txt); }
.ct-type-opt.on { border-color:var(--or); background:rgba(249,115,22,.08); color:var(--or); }
.ct-type-opt.on.gn { border-color:var(--gn); background:rgba(22,163,74,.07); color:var(--gn); }
.ct-type-opt.on.rd { border-color:#DC2626; background:rgba(220,38,38,.07); color:#DC2626; }

/* submit */
.ct-submit {
    width:100%; padding:12px;
    background:var(--or); color:#fff;
    border:none; border-radius:8px;
    font-size:14px; font-weight:700; letter-spacing:.3px;
    cursor:pointer; font-family:inherit;
    transition:background .15s,transform .1s;
    display:flex; align-items:center; justify-content:center; gap:6px;
    box-shadow: 0 2px 10px rgba(249,115,22,.3);
    margin-top:4px;
}
.ct-submit:hover  { background:var(--or2); }
.ct-submit:active { transform:scale(.98); }
.ct-submit:disabled { background:var(--bdr); color:var(--sub); box-shadow:none; cursor:not-allowed; }
.ct-submit svg { width:15px; height:15px; }

/* ── SIDEBAR ───────────────────────────────── */
.ct-sidebar { display:flex; flex-direction:column; gap:14px; }

.ct-info-card {
    background:var(--card); background-image:var(--hex);
    border:1px solid var(--bdr); border-radius:12px;
    padding:20px; transition:background .3s,border-color .3s;
}
.ct-info-card:hover { border-color:var(--or); }
.ct-info-card-row {
    display:flex; align-items:flex-start; gap:12px;
    padding:12px 0; border-bottom:1px solid var(--bdr);
}
.ct-info-card-row:last-child { border-bottom:none; padding-bottom:0; }
.ct-info-card-row:first-child { padding-top:0; }
.ct-info-ico {
    width:34px; height:34px; border-radius:8px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
}
.ct-info-ico svg { width:15px; height:15px; }
.ct-info-ico.or { background:rgba(249,115,22,.1); color:var(--or); }
.ct-info-ico.gn { background:rgba(22,163,74,.1);  color:var(--gn); }
.ct-info-ico.bl { background:rgba(37,99,235,.1);  color:#3B82F6;  }
.ct-info-ico.am { background:rgba(217,119,6,.1);  color:#D97706;  }
.ct-info-l { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--sub); margin:0 0 2px; }
.ct-info-v { font-size:13px; font-weight:600; color:var(--txt); margin:0; line-height:1.4; transition:color .3s; }

.ct-divider { height:1px; background:var(--bdr); }

.ct-sidebar-ttl {
    font-family:'Oswald',sans-serif;
    font-size:13px; font-weight:700; letter-spacing:1.5px;
    text-transform:uppercase; color:var(--or);
    margin:0 0 14px; display:flex; align-items:center; gap:8px;
}
.ct-sidebar-ttl::after { content:''; flex:1; height:1px; background:var(--bdr); }

/* Horarios table */
.ct-horarios { width:100%; border-collapse:collapse; }
.ct-horarios td { padding:6px 0; font-size:12px; border-bottom:1px solid var(--bdr); }
.ct-horarios tr:last-child td { border-bottom:none; }
.ct-horarios .day { color:var(--sub); font-weight:500; width:60%; }
.ct-horarios .hrs { color:var(--txt); font-weight:700; text-align:right; transition:color .3s; }
.ct-horarios .hrs.hl { color:var(--gn); }
</style>

<div class="ct-page" x-data="contactoPage()">

    {{-- HERO --}}
    <div class="ct-hero">
        <div class="ct-hero-badge">La 501 Sports Restaurant</div>
        <h1>Contac<span>to</span></h1>
        <p>Envíanos tus comentarios, sugerencias o preguntas. Nos encanta escuchar a nuestra comunidad.</p>
    </div>

    <div class="ct-wrap">

        {{-- ── FORMULARIO ── --}}
        <div>
            <div class="ct-card">
                <div class="ct-card-top"></div>
                <div class="ct-card-body">

                    <div class="ct-card-ttl">
                        <div class="ct-card-ttl-ico">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <h2>Formulario de Contacto</h2>
                    </div>
                    <p class="ct-card-sub">Completa el formulario y te responderemos a la brevedad.</p>

                    {{-- Alerta de éxito --}}
                    @if(session('success'))
                    <div class="ct-alert ok">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    {{-- Alerta de error --}}
                    @if($errors->any())
                    <div class="ct-alert err">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p>{{ $errors->first() }}</p>
                    </div>
                    @endif

                    <form action="{{ route('contacto.enviar') }}" method="POST"
                          class="ct-form" @submit="sending=true">
                        @csrf

                        {{-- Nombre + Email --}}
                        <div class="ct-g2">
                            <div>
                                <label class="ct-lbl">Nombre <span class="req">*</span></label>
                                <input type="text" name="name" class="ct-inp"
                                       placeholder="Tu nombre"
                                       value="{{ old('name') }}" required>
                            </div>
                            <div>
                                <label class="ct-lbl">Correo electrónico <span class="req">*</span></label>
                                <input type="email" name="email" class="ct-inp"
                                       placeholder="correo@ejemplo.com"
                                       value="{{ old('email') }}" required>
                            </div>
                        </div>

                        {{-- Tipo de mensaje — pills --}}
                        <div>
                            <label class="ct-lbl">Tipo de mensaje <span class="req">*</span></label>
                            <div class="ct-type-grid">
                                <div class="ct-type-opt" :class="tipo==='sugerencia' ? 'on gn':''"
                                     @click="tipo='sugerencia'">
                                    <span class="ico">💡</span>
                                    <span>Sugerencia</span>
                                </div>
                                <div class="ct-type-opt" :class="tipo==='pregunta' ? 'on bl':''"
                                     @click="tipo='pregunta'">
                                    <span class="ico">🤔</span>
                                    <span>Pregunta</span>
                                </div>
                                <div class="ct-type-opt" :class="tipo==='queja' ? 'on rd':''"
                                     @click="tipo='queja'">
                                    <span class="ico">⚠️</span>
                                    <span>Queja</span>
                                </div>
                            </div>
                            <input type="hidden" name="type" :value="tipo">
                        </div>

                        {{-- Asunto --}}
                        <div>
                            <label class="ct-lbl">Asunto <span class="req">*</span></label>
                            <input type="text" name="subject" class="ct-inp"
                                   placeholder="Motivo de tu mensaje"
                                   value="{{ old('subject') }}" required>
                        </div>

                        {{-- Mensaje --}}
                        <div>
                            <label class="ct-lbl">Mensaje <span class="req">*</span></label>
                            <textarea name="message" class="ct-ta"
                                      placeholder="Escribe tu mensaje aquí..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="ct-submit" :disabled="sending">
                            <template x-if="!sending">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </template>
                            <template x-if="sending">
                                <svg class="animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            </template>
                            <span x-text="sending ? 'Enviando...' : 'Enviar Mensaje'"></span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function contactoPage() {
    return {
        tipo:    '{{ old("type", "sugerencia") }}',
        sending: false,
    }
}
</script>

@endsection