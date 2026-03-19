@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Botón de regreso --}}
    <div class="mb-8">
        <a href="{{ route('admin.database') }}" class="inline-flex items-center gap-1 text-sm font-bold text-zinc-500 hover:text-zinc-800 dark:hover:text-white mb-4 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Volver a Gestión
        </a>
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Monitoreo del Sistema Relacional
        </h1>
        <p class="text-sm text-zinc-500 mt-1">Métricas en tiempo real del motor MySQL/MariaDB (v. {{ $version }})</p>
    </div>

    {{-- Cuadrícula de Métricas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        
        {{-- Tarjeta 1: Carga de Consultas (QPS) --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-5 shadow-sm">
            <div class="text-xs font-bold text-zinc-500 uppercase mb-2">Carga del Servidor (QPS)</div>
            <div class="flex items-end gap-2">
                <div class="text-3xl font-black text-indigo-600 dark:text-indigo-400">{{ $qps }}</div>
                <div class="text-sm font-medium text-zinc-400 mb-1">consultas / seg</div>
            </div>
            <div class="mt-3 text-[11px] text-zinc-500">Mide el tráfico y estrés actual de la base de datos.</div>
        </div>

        {{-- Tarjeta 2: Conexiones --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-5 shadow-sm">
            <div class="text-xs font-bold text-zinc-500 uppercase mb-2">Conexiones Activas</div>
            <div class="flex items-end gap-2">
                <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ $connections }}</div>
                <div class="text-sm font-medium text-zinc-400 mb-1">/ {{ $maxConnections }} límite</div>
            </div>
            <div class="mt-3 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                @php $porcentaje = $maxConnections > 0 ? ($connections / $maxConnections) * 100 : 0; @endphp
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
            </div>
        </div>

        {{-- Tarjeta 3: Consultas Lentas --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-5 shadow-sm">
            <div class="text-xs font-bold text-zinc-500 uppercase mb-2">Cuellos de Botella</div>
            <div class="flex items-end gap-2">
                <div class="text-3xl font-black {{ $slowQueries > 0 ? 'text-red-500' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $slowQueries }}</div>
                <div class="text-sm font-medium text-zinc-400 mb-1">consultas lentas</div>
            </div>
            <div class="mt-3 text-[11px] text-zinc-500">Queries que superan el límite de tiempo de ejecución (long_query_time).</div>
        </div>

        {{-- Tarjeta 4: Peso en Disco --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-5 shadow-sm">
            <div class="text-xs font-bold text-zinc-500 uppercase mb-2">Almacenamiento Total</div>
            <div class="flex items-end gap-2">
                <div class="text-3xl font-black text-orange-600 dark:text-orange-400">{{ $dbSize }}</div>
                <div class="text-sm font-medium text-zinc-400 mb-1">MB</div>
            </div>
            <div class="mt-3 text-[11px] text-zinc-500">Peso real sumando datos e índices relacionales.</div>
        </div>

        {{-- Tarjeta 5: Tiempo de Actividad --}}
        <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-white/10 rounded-2xl p-5 shadow-sm lg:col-span-2">
            <div class="text-xs font-bold text-zinc-500 uppercase mb-2">Tiempo de Actividad (Uptime)</div>
            <div class="flex items-end gap-2">
                <div class="text-2xl font-black text-zinc-800 dark:text-white">{{ $uptimeStr }}</div>
            </div>
            <div class="mt-2 text-[11px] text-zinc-500">Tiempo continuo sin caídas del motor relacional desde el último reinicio del servidor Hostinger.</div>
        </div>

    </div>
</div>
@endsection
