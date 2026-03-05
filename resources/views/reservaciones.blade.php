@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6 relative">
    
    {{-- ETIQUETA DE "EN DESARROLLO" --}}
    <div class="absolute top-0 right-6 md:right-0 bg-yellow-500 text-black font-extrabold px-6 py-2 rounded-b-2xl shadow-lg text-sm tracking-widest uppercase flex items-center gap-2 animate-pulse">
        <span>🚧</span> En Producción
    </div>

    <div class="text-center mb-10 mt-8 md:mt-0">
        <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">Reservaciones</h1>
        <p class="text-zinc-500 text-lg">Reserva tu mesa con anticipación</p>
    </div>

    <div class="bg-zinc-50 dark:bg-[#1a1612]/50 border border-zinc-200 dark:border-zinc-800 p-6 rounded-[32px] mb-8 flex gap-4 items-start">
        <div class="bg-zinc-100 dark:bg-zinc-800 p-3 rounded-2xl text-xl">🎉</div>
        <div>
            <h3 class="font-bold text-zinc-900 dark:text-white mb-1">Eventos Especiales</h3>
            <p class="text-sm text-zinc-500 leading-relaxed">
                Para eventos especiales o grupos grandes (más de 10 personas), por favor comunícate directamente con el restaurante para coordinar los detalles.
            </p>
        </div>
    </div>

    {{-- FORMULARIO DESACTIVADO (opacity-60 para que se note que no funciona) --}}
    <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 p-8 rounded-[40px] shadow-xl relative opacity-70 cursor-not-allowed">
        
        {{-- Bloqueador invisible para evitar clics --}}
        <div class="absolute inset-0 z-10" title="Formulario en desarrollo"></div>

        <div class="flex items-center gap-3 text-green-500 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-xl font-bold dark:text-white">Nueva Reservación (Próximamente)</h2>
        </div>
        
        <p class="text-sm text-zinc-500 mb-8">Completa el formulario para reservar tu mesa. Solo se permite una reservación por horario.</p>

        <form action="#" method="POST" class="space-y-6" onsubmit="event.preventDefault();">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Nombre Completo</label>
                    <input type="text" placeholder="Juan Perez" disabled
                        class="w-full bg-zinc-100 dark:bg-zinc-900/80 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-400 dark:text-zinc-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Teléfono</label>
                    <div class="relative">
                        <span class="absolute left-4 top-4 text-zinc-400">📞</span>
                        <input type="tel" placeholder="555-123-4567" disabled
                            class="w-full bg-zinc-100 dark:bg-zinc-900/80 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 pl-12 text-zinc-400 dark:text-zinc-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium dark:text-zinc-300">Correo Electrónico</label>
                <div class="relative">
                    <span class="absolute left-4 top-4 text-zinc-400">✉️</span>
                    <input type="email" placeholder="correo@ejemplo.com" disabled
                        class="w-full bg-zinc-100 dark:bg-zinc-900/80 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 pl-12 text-zinc-400 dark:text-zinc-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Fecha</label>
                    <input type="date" disabled
                        class="w-full bg-zinc-100 dark:bg-zinc-900/80 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-400 dark:text-zinc-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Hora</label>
                    <select disabled
                        class="w-full bg-zinc-100 dark:bg-zinc-900/80 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-400 dark:text-zinc-500 outline-none appearance-none">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="14:00">2:00 PM</option>
                        <option value="16:00">4:00 PM</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Personas</label>
                    <select disabled
                        class="w-full bg-zinc-100 dark:bg-zinc-900/80 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-400 dark:text-zinc-500 outline-none appearance-none">
                        <option value="" disabled selected>Cantidad</option>
                        <option value="2">2 Personas</option>
                    </select>
                </div>
            </div>

            <button type="button" disabled
                class="w-full py-4 bg-zinc-300 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 font-bold rounded-2xl cursor-not-allowed">
                Módulo en Desarrollo
            </button>
        </form>
    </div>
</div>
@endsection