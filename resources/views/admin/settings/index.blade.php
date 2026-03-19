@extends('layouts.admin')

@section('content')

<style>
    .as {
        --accent:   #2563EB;
        --accent2:  #1D4ED8;

        --bg:       #F8F8F8;
        --bg-card:  #FFFFFF;
        --bg-input: #F4F4F5;
        --txt:      #18181B;
        --txt-sub:  #71717A;
        --bdr:      #E4E4E7;
    }
    .dark .as {
        --bg:       #0A0A0A;
        --bg-card:  #111111;
        --bg-input: #1C1C1C;
        --txt:      #FAFAFA;
        --txt-sub:  #71717A;
        --bdr:      rgba(255,255,255,0.08);
    }

    .as { background: var(--bg); min-height: 100%; }

    /* page header */
    .as-header { margin-bottom: 24px; }
    .as-header h1 { font-size: 20px; font-weight: 700; color: var(--txt); margin: 0 0 2px; }
    .as-header p  { font-size: 13px; color: var(--txt-sub); margin: 0; }

    /* grid */
    .as-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    /* card */
    .as-card {
        background: var(--bg-card);
        border: 1px solid var(--bdr);
        border-radius: 10px;
        overflow: hidden;
    }
    .as-card-head {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--bdr);
    }
    .as-card-head-icon {
        width: 30px; height: 30px; border-radius: 7px;
        background: rgba(37,99,235,.08);
        border: 1px solid rgba(37,99,235,.15);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .as-card-head-icon svg { width: 15px; height: 15px; color: var(--accent); }
    .as-card-head h2 { font-size: 14px; font-weight: 700; color: var(--txt); margin: 0; }
    .as-card-body { padding: 18px; display: flex; flex-direction: column; gap: 14px; }

    /* labels & inputs */
    .as-label {
        display: block; font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: .5px;
        color: var(--txt-sub); margin-bottom: 4px;
    }
    .as-input {
        width: 100%; padding: 8px 10px;
        background: var(--bg-input); border: 1px solid var(--bdr);
        border-radius: 7px; font-size: 13px; color: var(--txt);
        outline: none; transition: border-color .15s, box-shadow .15s;
    }
    .as-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }

    /* info box */
    .as-info {
        background: var(--bg-input);
        border: 1px solid var(--bdr);
        border-radius: 7px;
        padding: 10px 12px;
        font-size: 12px; color: var(--txt-sub); line-height: 1.6;
    }
    .as-info strong { color: var(--txt); font-weight: 600; }

    /* logo preview */
    .as-logo-preview {
        width: 100%; height: 130px;
        background: var(--bg-input);
        border: 1px solid var(--bdr);
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; padding: 16px;
    }
    .as-logo-preview img { max-width: 100%; max-height: 100%; object-fit: contain; }

    /* file picker */
    .as-file-label {
        display: inline-flex; align-items: center; gap: 7px;
        width: 100%;
        padding: 8px 12px;
        background: var(--bg-input); border: 1px solid var(--bdr);
        border-radius: 7px; cursor: pointer;
        font-size: 13px; color: var(--txt-sub); font-weight: 500;
        transition: border-color .15s, color .15s;
    }
    .as-file-label:hover { border-color: var(--accent); color: var(--accent); }
    .as-file-label svg { width: 14px; height: 14px; flex-shrink: 0; }

    /* map preview */
    .as-map-preview {
        width: 100%; height: 160px;
        background: var(--bg-input);
        border: 1px solid var(--bdr);
        border-radius: 7px; overflow: hidden;
        position: relative;
    }
    .as-map-preview iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
    .as-map-empty {
        width: 100%; height: 100%;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 6px;
    }
    .as-map-empty svg { width: 24px; height: 24px; color: var(--txt-sub); opacity: .4; }
    .as-map-empty span { font-size: 12px; color: var(--txt-sub); }

    /* schedule rows */
    .as-schedule { display: flex; flex-direction: column; gap: 6px; }
    .as-sched-row {
        display: flex; align-items: center; gap: 10px;
    }
    .as-sched-day {
        width: 80px; flex-shrink: 0;
        font-size: 12px; font-weight: 600;
        color: var(--txt-sub);
    }
    .as-sched-row .as-input { flex: 1; }
    .as-tip {
        font-size: 11px; color: var(--txt-sub);
        background: var(--bg-input);
        border: 1px solid var(--bdr);
        border-radius: 6px; padding: 6px 10px;
    }

    /* submit button */
    .as-btn {
        width: 100%; padding: 9px;
        background: var(--accent); color: #fff;
        border: none; border-radius: 7px;
        font-size: 13px; font-weight: 600;
        cursor: pointer; transition: background .15s;
        box-shadow: 0 1px 3px rgba(37,99,235,.3);
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .as-btn:hover { background: var(--accent2); }
    .as-btn:disabled { opacity: .6; cursor: not-allowed; }
    .as-btn svg { width: 14px; height: 14px; animation: spin .8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 768px) {
        .as-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="as">

    <div class="as-header">
        <h1>Configuración</h1>
        <p>Administra la información general del sitio web.</p>
    </div>

    <div class="as-grid">

        {{-- ── LOGO ── --}}
        <div class="as-card" x-data="{ imagePreview: null, isSubmitting: false }">
            <div class="as-card-head">
                <div class="as-card-head-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2>Logo Principal</h2>
            </div>
            <div class="as-card-body">
                <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data"
                      @submit="if(isSubmitting){$event.preventDefault()}else{isSubmitting=true}">
                    @csrf

                    {{-- Preview --}}
                    <div class="as-logo-preview">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" alt="Vista previa del nuevo logo">
                        </template>
                        <template x-if="!imagePreview">
                            @php
                                $logoPath = ($logo && str_starts_with($logo->value, 'logos/'))
                                    ? asset('storage/' . $logo->value)
                                    : asset('images/logo_501.png');
                            @endphp
                            <img src="{{ $logoPath }}" alt="Logo actual">
                        </template>
                    </div>

                    {{-- File picker --}}
                    <label class="as-file-label" for="logo-upload">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span>Seleccionar imagen…</span>
                        <input type="file" id="logo-upload" name="logo" class="hidden" accept="image/*" required
                               @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>imagePreview=e.target.result;r.readAsDataURL(f)}">
                    </label>

                    <button type="submit" :disabled="isSubmitting" class="as-btn">
                        <template x-if="isSubmitting">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </template>
                        <span x-text="isSubmitting ? 'Guardando…' : 'Guardar Logo'"></span>
                    </button>
                </form>
            </div>
        </div>

        {{-- ── MAPA ── --}}
        <div class="as-card"
             x-data="{
                rawMapInput: '{{ $map_url->value ?? '' }}',
                isSubmitting: false,
                get mapPreview() {
                    if (!this.rawMapInput) return '';
                    let val = this.rawMapInput;
                    if (val.includes('output=embed') || val.includes('google.com/maps/embed')) return val;
                    let query = val;
                    if (val.includes('/place/')) {
                        let m = val.match(/\/place\/([^\/]+)/);
                        if (m) { try { query = decodeURIComponent(m[1].replace(/\+/g,' ')); } catch(e) { query = m[1]; } }
                    } else if (val.includes('/@')) {
                        let m = val.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                        if (m) query = m[1]+','+m[2];
                    }
                    return 'https://maps.google.com/maps?q='+encodeURIComponent(query)+'&output=embed';
                }
             }">
            <div class="as-card-head">
                <div class="as-card-head-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2>Ubicación en el Mapa</h2>
            </div>
            <div class="as-card-body">
                <form action="{{ route('admin.settings.map') }}" method="POST"
                      @submit="if(isSubmitting){$event.preventDefault()}else{isSubmitting=true}">
                    @csrf
                    <input type="hidden" name="map_url" :value="mapPreview">

                    <div class="as-info">
                        <strong>¿Cómo actualizar?</strong> Pega la URL de Google Maps o escribe el nombre del lugar.
                        Ej: <em>La 501 Centro, Huejutla</em>
                    </div>

                    <div>
                        {{-- FIX L272: label for="map-input" + id en el input --}}
                        <label class="as-label" for="map-input">Dirección o enlace</label>
                        <input type="text" id="map-input" x-model="rawMapInput" required
                               placeholder="Ej: La 501 Centro, Huejutla"
                               class="as-input">
                    </div>

                    {{-- Preview mapa --}}
                    <div class="as-map-preview">
                        <template x-if="mapPreview">
                            <iframe :src="mapPreview" allowfullscreen="" loading="lazy"
                                    title="Vista previa del mapa"></iframe>
                        </template>
                        <template x-if="!mapPreview">
                            <div class="as-map-empty">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 13l4.553 2.276A1 1 0 0021 21.382V10.618a1 1 0 00-.553-.894L15 7m0 13V7m0 0L9 4"/>
                                </svg>
                                <span>Escribe algo para ver el mapa</span>
                            </div>
                        </template>
                    </div>

                    <button type="submit" :disabled="isSubmitting" class="as-btn">
                        <template x-if="isSubmitting">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </template>
                        <span x-text="isSubmitting ? 'Guardando…' : 'Guardar Mapa'"></span>
                    </button>
                </form>
            </div>
        </div>

        {{-- ── DIRECCIÓN ── --}}
        <div class="as-card" x-data="{ isSubmitting: false }">
            <div class="as-card-head">
                <div class="as-card-head-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <h2>Dirección del Local</h2>
            </div>
            <div class="as-card-body">
                <form action="{{ route('admin.settings.address') }}" method="POST"
                      @submit="if(isSubmitting){$event.preventDefault()}else{isSubmitting=true}">
                    @csrf

                    <div>
                        {{-- FIX L322: label for="addr-line1" + id en el input --}}
                        <label class="as-label" for="addr-line1">Calle y número</label>
                        <input type="text" id="addr-line1" name="address_line1"
                               value="{{ $address_line1->value ?? '' }}"
                               required placeholder="Av. Deportiva #501"
                               class="as-input">
                    </div>
                    <div>
                        {{-- FIX L329: label for="addr-line2" + id en el input --}}
                        <label class="as-label" for="addr-line2">Colonia o sector</label>
                        <input type="text" id="addr-line2" name="address_line2"
                               value="{{ $address_line2->value ?? '' }}"
                               placeholder="Col. Centro"
                               class="as-input">
                    </div>
                    <div>
                        {{-- FIX L336: label for="addr-line3" + id en el input --}}
                        <label class="as-label" for="addr-line3">Ciudad, estado y CP</label>
                        <input type="text" id="addr-line3" name="address_line3"
                               value="{{ $address_line3->value ?? '' }}"
                               placeholder="CP 43000, Huejutla de Reyes, Hgo."
                               class="as-input">
                    </div>

                    <button type="submit" :disabled="isSubmitting" class="as-btn">
                        <template x-if="isSubmitting">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </template>
                        <span x-text="isSubmitting ? 'Guardando…' : 'Guardar Dirección'"></span>
                    </button>
                </form>
            </div>
        </div>

        {{-- ── HORARIOS ── --}}
        <div class="as-card" x-data="{ isSubmitting: false }">
            <div class="as-card-head">
                <div class="as-card-head-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2>Horario de Atención</h2>
            </div>
            <div class="as-card-body">
                <form action="{{ route('admin.settings.schedule') }}" method="POST"
                      @submit="if(isSubmitting){$event.preventDefault()}else{isSubmitting=true}">
                    @csrf

                    <p class="as-tip">Escribe "Cerrado" en los días que no abren.</p>

                    @php
                        $days = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
                    @endphp

                    <div class="as-schedule">
                        @foreach($days as $day)
                        @php $dayKey = strtolower($day); @endphp
                        <div class="as-sched-row">
                            {{-- FIX: label for apuntando al id único del input de cada día --}}
                            <label class="as-sched-day" for="sched-{{ $dayKey }}">{{ $day }}</label>
                            <input type="text" id="sched-{{ $dayKey }}" name="schedule_{{ $dayKey }}"
                                   value="{{ $schedule[$dayKey] ?? '12:30 PM – 10:30 PM' }}"
                                   class="as-input">
                        </div>
                        @endforeach
                    </div>

                    <button type="submit" :disabled="isSubmitting" class="as-btn">
                        <template x-if="isSubmitting">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </template>
                        <span x-text="isSubmitting ? 'Guardando…' : 'Guardar Horarios'"></span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
