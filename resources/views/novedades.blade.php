@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-16">
    
    {{-- Título Principal --}}
    <div class="text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-zinc-900 dark:text-white mb-4">
            Novedades <span class="text-green-500">La 501</span>
        </h1>
        <p class="text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
            Entérate de lo último en deportes, avisos importantes y nuestros próximos eventos.
        </p>
    </div>

    {{-- ================= SECCIÓN 1: AVISOS ================= --}}
    @if($avisos->count() > 0)
    <section>
        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">⚠️ Avisos Importantes</h2>
            <div class="h-1 flex-grow bg-zinc-200 dark:bg-zinc-800 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($avisos as $item)
                <article class="group bg-white dark:bg-[#1a1612] rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden border border-zinc-200 dark:border-white/5 flex flex-col h-full">
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ asset('storage/' . $item->image) }}" onerror="this.src='https://via.placeholder.com/600x400?text=Sin+Imagen'" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                {{ $item->category }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2 line-clamp-2 group-hover:text-green-500 transition">
                            {{ $item->title }}
                        </h3>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm line-clamp-3 mb-4 flex-grow">
                            {{ $item->content }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================= SECCIÓN 2: DEPORTES ================= --}}
    @if($deportes->count() > 0)
    <section>
        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">⚽ Deportes</h2>
            <div class="h-1 flex-grow bg-zinc-200 dark:bg-zinc-800 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($deportes as $item)
                <article class="group bg-white dark:bg-[#1a1612] rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden border border-zinc-200 dark:border-white/5 flex flex-col h-full">
                    {{-- Imagen --}}
                    <div class="relative overflow-hidden h-48">
                        {{-- Ajustamos la ruta de la imagen --}}
                        <img src="{{ asset('storage/' . $item->image) }}" onerror="this.src='https://via.placeholder.com/600x400?text=Sin+Imagen'" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $item->category }}
                            </span>
                        </div>
                    </div>
                    {{-- Contenido --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2 line-clamp-2 group-hover:text-green-500 transition">
                            {{ $item->title }}
                        </h3>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm line-clamp-3 mb-4 flex-grow">
                            {{ $item->content }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================= SECCIÓN 3: EVENTOS ================= --}}
    @if($eventos->count() > 0)
    <section>
        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">🎉 Próximos Eventos</h2>
            <div class="h-1 flex-grow bg-zinc-200 dark:bg-zinc-800 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($eventos as $item)
                <article class="group bg-white dark:bg-[#1a1612] rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden border border-zinc-200 dark:border-white/5 flex flex-col h-full">
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ asset('storage/' . $item->image) }}" onerror="this.src='https://via.placeholder.com/600x400?text=Sin+Imagen'" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                {{ $item->category }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2 line-clamp-2 group-hover:text-green-500 transition">
                            {{ $item->title }}
                        </h3>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm line-clamp-3 mb-4 flex-grow">
                            {{ $item->content }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Mensaje si no hay nada --}}
    @if($deportes->isEmpty() && $avisos->isEmpty() && $eventos->isEmpty())
        <div class="text-center py-20 bg-zinc-50 dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800">
            <p class="text-xl text-zinc-500">No hay novedades publicadas por el momento.</p>
        </div>
    @endif

</div>
@endsection