@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
    
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Configuración del Sistema</h1>
        <p class="text-zinc-500 mt-2">Administra la información general de la página web.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Tarjeta para cambiar el Logo --}}
        <div class="bg-white dark:bg-[#1a1612] rounded-[32px] p-8 shadow-sm border border-zinc-200 dark:border-white/5" x-data="{ imagePreview: null, isSubmitting: false }">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">Logo Principal</h2>
            
            <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data" @submit="if(isSubmitting) { $event.preventDefault(); } else { isSubmitting = true; }">
                @csrf
                
                <div class="flex flex-col items-center gap-6">
                    {{-- Previsualizador del Logo actual / nuevo --}}
                    <div class="w-48 h-48 bg-zinc-100 dark:bg-black/20 rounded-3xl flex items-center justify-center overflow-hidden border border-zinc-200 dark:border-white/10 p-4">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="w-full h-full object-contain">
                        </template>
                        <template x-if="!imagePreview">
                            @php
                                // Verificamos si la ruta es la por defecto o está en storage
                                $logoPath = ($logo && str_starts_with($logo->value, 'logos/')) 
                                            ? asset('storage/' . $logo->value) 
                                            : asset('images/logo_501.png');
                            @endphp
                            <img src="{{ $logoPath }}" alt="Logo Actual" class="w-full h-full object-contain">
                        </template>
                    </div>

                    {{-- Input File Oculto --}}
                    <label class="cursor-pointer bg-zinc-100 dark:bg-white/5 hover:bg-zinc-200 dark:hover:bg-white/10 text-zinc-700 dark:text-white px-6 py-3 rounded-xl font-bold transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Seleccionar nueva imagen
                        <input type="file" name="logo" class="hidden" accept="image/*" required
                               @change="
                                    const file = $event.target.files[0];
                                    if(file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => { imagePreview = e.target.result; };
                                        reader.readAsDataURL(file);
                                    }
                               ">
                    </label>

                    {{-- Botón Guardar --}}
                    <button type="submit" :disabled="isSubmitting" :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition flex justify-center items-center gap-2 mt-4">
                        <span x-show="!isSubmitting">Guardar Logo</span>
                        <span x-show="isSubmitting" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Actualizando...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Tarjeta para cambiar el Mapa (Mucha más fácil de usar) --}}
        <div class="bg-white dark:bg-[#1a1612] rounded-[32px] p-8 shadow-sm border border-zinc-200 dark:border-white/5" 
             x-data="{ 
                rawMapInput: '{{ $map_url->value ?? '' }}', 
                isSubmitting: false,
                get mapPreview() {
                    if (!this.rawMapInput) return '';
                    let val = this.rawMapInput;
                    
                    // Si ya es un enlace configurado correctamente, lo deja igual
                    if (val.includes('output=embed') || val.includes('google.com/maps/embed')) {
                        return val;
                    }
                    
                    let query = val;
                    
                    // Si pegó la URL larga de Google Maps, extraemos el nombre del lugar
                    if (val.includes('/place/')) {
                        let match = val.match(/\/place\/([^\/]+)/);
                        if (match && match[1]) {
                            try {
                                query = decodeURIComponent(match[1].replace(/\+/g, ' '));
                            } catch(e) {
                                query = match[1].replace(/\+/g, ' ');
                            }
                        }
                    } 
                    // Si pegó una URL con coordenadas
                    else if (val.includes('/@')) {
                        let match = val.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                        if (match) {
                            query = match[1] + ',' + match[2];
                        }
                    }
                    
                    // Convertimos todo a un mapa insertable
                    return 'https://maps.google.com/maps?q=' + encodeURIComponent(query) + '&output=embed';
                }
             }">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">Ubicación en el Mapa</h2>
            
            <form action="{{ route('admin.settings.map') }}" method="POST" @submit="if(isSubmitting) { $event.preventDefault(); } else { isSubmitting = true; }">
                @csrf
                
                {{-- INPUT OCULTO QUE ENVÍA EL ENLACE CORRECTO AL SERVIDOR --}}
                <input type="hidden" name="map_url" :value="mapPreview">
                
                <div class="flex flex-col gap-6">
                    {{-- Instrucciones sencillas --}}
                    <div class="text-sm text-zinc-500 bg-zinc-50 dark:bg-white/5 p-4 rounded-xl border border-zinc-200 dark:border-white/10">
                        <p class="font-bold text-zinc-700 dark:text-zinc-300 mb-1">¿Cómo actualizar el mapa?</p>
                        <p>Es muy fácil. Puedes hacer cualquiera de estas opciones:</p>
                        <ul class="list-disc pl-4 mt-1 space-y-1">
                            <li>Pegar la <strong>URL normal completa</strong> de Google Maps (la de la barra de direcciones).</li>
                            <li>O simplemente escribir el <strong>nombre del local y ciudad</strong> (Ej: <em>La 501 Centro, Huejutla</em>).</li>
                        </ul>
                    </div>

                    {{-- Input de texto visible para el usuario --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Dirección o Enlace</label>
                        <input type="text" x-model="rawMapInput" required placeholder="Ej: La 501 Centro, Huejutla" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                    </div>

                    {{-- Previsualizador del Mapa en tiempo real --}}
                    <div class="w-full h-48 bg-zinc-100 dark:bg-black/20 rounded-2xl overflow-hidden border border-zinc-200 dark:border-white/10 relative">
                        <template x-if="mapPreview">
                            <iframe :src="mapPreview" class="absolute inset-0 w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                        </template>
                        <template x-if="!mapPreview">
                            <div class="w-full h-full flex flex-col items-center justify-center text-zinc-400">
                                <span class="text-2xl mb-2">🗺️</span>
                                <span class="text-xs">Escribe algo para ver el mapa</span>
                            </div>
                        </template>
                    </div>

                    {{-- Botón Guardar --}}
                    <button type="submit" :disabled="isSubmitting" :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition flex justify-center items-center gap-2 mt-2">
                        <span x-show="!isSubmitting">Guardar Mapa</span>
                        <span x-show="isSubmitting" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Actualizando...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Tarjeta para cambiar la Dirección --}}
        <div class="bg-white dark:bg-[#1a1612] rounded-[32px] p-8 shadow-sm border border-zinc-200 dark:border-white/5" x-data="{ isSubmitting: false }">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">Dirección del Local</h2>
            
            <form action="{{ route('admin.settings.address') }}" method="POST" @submit="if(isSubmitting) { $event.preventDefault(); } else { isSubmitting = true; }">
                @csrf
                
                <div class="flex flex-col gap-5">
                    
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Línea 1: Calle y Número</label>
                        <input type="text" name="address_line1" value="{{ $address_line1->value ?? '' }}" required placeholder="Ej: Av. Deportiva #501" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Línea 2: Colonia o Sector</label>
                        <input type="text" name="address_line2" value="{{ $address_line2->value ?? '' }}" placeholder="Ej: Col. Centro" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Línea 3: Ciudad, Estado y CP</label>
                        <input type="text" name="address_line3" value="{{ $address_line3->value ?? '' }}" placeholder="Ej: CP 43000, Huejutla de Reyes, Hgo." class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                    </div>

                    <button type="submit" :disabled="isSubmitting" :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition flex justify-center items-center gap-2 mt-3">
                        <span x-show="!isSubmitting">Guardar Dirección</span>
                        <span x-show="isSubmitting" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Tarjeta para cambiar los Horarios --}}
        <div class="bg-white dark:bg-[#1a1612] rounded-[32px] p-8 shadow-sm border border-zinc-200 dark:border-white/5" x-data="{ isSubmitting: false }">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-2xl">🕒</span>
                <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Horario de Atención</h2>
            </div>
            
            <form action="{{ route('admin.settings.schedule') }}" method="POST" @submit="if(isSubmitting) { $event.preventDefault(); } else { isSubmitting = true; }">
                @csrf
                
                <div class="space-y-3">
                    <p class="text-xs text-zinc-500 mb-4">Tip: Si un día no abren, puedes escribir "Cerrado".</p>

                    @php
                        $days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
                    @endphp

                    @foreach($days as $day)
                        @php $dayKey = strtolower($day); @endphp
                        <div class="flex items-center justify-between gap-4">
                            <label class="w-24 text-sm font-bold text-zinc-700 dark:text-zinc-300">{{ $day }}</label>
                            <input type="text" name="schedule_{{ $dayKey }}" value="{{ $schedule[$dayKey] ?? '12:30 PM – 10:30 PM' }}" class="flex-1 bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                        </div>
                    @endforeach

                    <button type="submit" :disabled="isSubmitting" :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition flex justify-center items-center gap-2 mt-6">
                        <span x-show="!isSubmitting">Guardar Horarios</span>
                        <span x-show="isSubmitting" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection