@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Encabezado --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
            Gestión del Sistema y Base de Datos
        </h1>
        <p class="text-sm text-zinc-500 mt-1">Administración avanzada de datos, copias de seguridad y tareas programadas.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 rounded-xl text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- TARJETA 1: RESPALDO (BACKUP) --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-6 shadow-sm">
            <div class="w-12 h-12 bg-blue-500/10 text-blue-500 rounded-xl flex items-center justify-center mb-4 border border-blue-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            </div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Copia de Seguridad (Backup)</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6 line-clamp-2">
                Genera un archivo .sql con toda la información actual del sistema (usuarios, ventas, inventario). Recomendado hacer uno semanal.
            </p>
            <form action="{{ route('admin.database.backup') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-blue-500/30 flex justify-center items-center gap-2">
                    Generar y Descargar Backup
                </button>
            </form>
        </div>

        {{-- TARJETA 2: AUTOMATIZACIÓN INTELIGENTE --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-6 shadow-sm" 
             x-data="{ 
                 autoEnabled: {{ \App\Models\Setting::where('key', 'backup_enabled')->value('value') == '1' ? 'true' : 'false' }}, 
                 frecuencia: '{{ \App\Models\Setting::where('key', 'backup_frecuencia')->value('value') ?? 'intervalo' }}' 
             }">
            
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-green-500/10 text-green-500 rounded-xl flex items-center justify-center border border-green-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                
                {{-- Toggle Switch (Interruptor) --}}
                <button type="button" 
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none" 
                        :class="autoEnabled ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-700'" 
                        @click="autoEnabled = !autoEnabled">
                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" 
                          :class="autoEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
            </div>
            
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Respaldo Automático</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">El sistema guardará copias de seguridad de forma invisible y limpiará automáticamente los archivos con más de 3 días de antigüedad para optimizar el almacenamiento.</p>

            {{-- Mensaje cuando está apagado --}}
            <div x-show="!autoEnabled" class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-white/5 text-sm text-zinc-500 text-center">
                El respaldo automático está desactivado. Usa el interruptor de arriba para configurarlo.
            </div>

            {{-- Formulario de Configuración --}}
            <form action="{{ route('admin.database.saveAuto') }}" method="POST" 
                  x-show="autoEnabled" x-transition.opacity 
                  class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="auto_backup" value="1">
                
                {{-- Obligamos al sistema a borrar los respaldos viejos sin preguntarle al usuario --}}
                <input type="hidden" name="delete_old" value="1">

                {{-- Opciones de Frecuencia --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-500 uppercase mb-1">Frecuencia</label>
                    <select name="frecuencia" x-model="frecuencia" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-white outline-none focus:border-green-500">
                        <option value="intervalo">Por Intervalos Cortos</option>
                        <option value="diario">Diariamente</option>
                        <option value="semanal">Semanalmente</option>
                        <option value="mensual">Mensualmente</option>
                    </select>
                </div>

                {{-- Campo: Hora exacta (Se muestra si NO es intervalo) --}}
                <div x-show="frecuencia !== 'intervalo'">
                    <label class="block text-xs font-bold text-zinc-500 uppercase mb-1">Hora de ejecución</label>
                    <input type="time" name="hora" value="{{ \App\Models\Setting::where('key', 'backup_hora')->value('value') ?? '03:00' }}" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-white outline-none focus:border-green-500">
                </div>

                {{-- Campo: Intervalos (Se muestra SOLO si elige 'intervalo') --}}
                @php $savedInterval = \App\Models\Setting::where('key', 'backup_intervalo')->value('value') ?? '60'; @endphp
                <div x-show="frecuencia === 'intervalo'">
                    <label class="block text-xs font-bold text-zinc-500 uppercase mb-1">Cada cuánto tiempo</label>
                    <select name="intervalo" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-white outline-none focus:border-green-500">
                        <option value="15" {{ $savedInterval == '15' ? 'selected' : '' }}>Cada 15 minutos</option>
                        <option value="30" {{ $savedInterval == '30' ? 'selected' : '' }}>Cada 30 minutos</option>
                        <option value="60" {{ $savedInterval == '60' ? 'selected' : '' }}>Cada hora (Recomendado)</option>
                    </select>
                </div>

                {{-- Información de limpieza --}}
                <div class="flex items-start gap-2 pt-2 pb-2">
                    <svg class="w-4 h-4 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-[12px] text-zinc-500 leading-tight">
                        Para optimizar el rendimiento del servidor, los respaldos antiguos se eliminarán automáticamente pasadas las 72 horas.
                    </p>
                </div>

                {{-- Botón Guardar --}}
                <button type="submit" class="w-full mt-2 py-3 bg-zinc-900 hover:bg-zinc-800 dark:bg-white dark:hover:bg-zinc-200 dark:text-black text-white text-sm font-bold rounded-xl transition shadow-lg flex justify-center items-center gap-2">
                    Guardar Configuración
                </button>
            </form>
        </div>

        {{-- TARJETA 3: RESTAURACIÓN --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-6 shadow-sm opacity-80">
            <div class="w-12 h-12 bg-orange-500/10 text-orange-500 rounded-xl flex items-center justify-center mb-4 border border-orange-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            </div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Restauración de Datos</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                Sube un archivo .sql generado previamente para sobreescribir la base de datos actual en caso de emergencia.
            </p>
            <button class="w-full py-3 bg-zinc-200 dark:bg-zinc-800 text-zinc-500 cursor-not-allowed text-sm font-bold rounded-xl flex justify-center items-center gap-2" disabled>
                Módulo en construcción
            </button>
        </div>

        {{-- TARJETA 4: AUTOMATIZACIÓN DE TAREAS --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-6 shadow-sm md:col-span-2">
            <div class="w-12 h-12 bg-green-500/10 text-green-500 rounded-xl flex items-center justify-center mb-4 border border-green-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Automatización (Cron Jobs)</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                Instrucciones para automatizar procesos recurrentes (como mantenimiento de índices o reportes) en el servidor de Hostinger.
            </p>
            <div class="bg-zinc-50 dark:bg-[#1a1612] p-4 rounded-xl border border-zinc-200 dark:border-white/5 text-sm text-zinc-600 dark:text-zinc-300 font-mono">
                1. Inicia sesión en Hostinger (hPanel).<br>
                2. Ve a Avanzado > Tareas Cron (Cron Jobs).<br>
                3. Ejecutar el siguiente comando cada 24 horas:<br>
                <span class="text-blue-600 dark:text-blue-400 font-bold mt-2 block">php /home/u734437104_la501Prueba/artisan schedule:run</span>
            </div>
        </div>

    </div>
</div>
@endsection