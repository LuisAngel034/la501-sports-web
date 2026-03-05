@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-16 px-6">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">Promociones Especiales</h1>
        <p class="text-zinc-500 text-lg">Aprovecha nuestras ofertas exclusivas para ti y tu familia</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @forelse($promotions as $promo)
        <div class="group relative bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800/50 rounded-[40px] overflow-hidden shadow-xl transition-all hover:border-green-500/50 flex flex-col h-full">
            
            {{-- SECCIÓN DE IMAGEN / COLOR Y EMOJI --}}
            <div class="h-48 relative overflow-hidden bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center {{ !$promo->image ? 'bg-gradient-to-br ' . $promo->color_gradient : '' }}">
                
                @if($promo->image)
                    {{-- Si subiste una imagen real --}}
                    <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-500">
                @else
                    {{-- Si no, usa el emoji --}}
                    <span class="text-6xl group-hover:scale-110 transition duration-500 z-10">{{ $promo->icon }}</span>
                @endif
                
                {{-- Etiqueta superior (ej. ¡Solo Jueves!) --}}
                @if($promo->tag)
                <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-md px-4 py-1 rounded-full text-white font-bold text-sm italic z-20">
                    {{ $promo->tag }}
                </div>
                @endif
            </div>
            
            {{-- INFORMACIÓN TEXTUAL --}}
            <div class="p-8 flex flex-col flex-grow">
                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">{{ $promo->title }}</h3>
                <p class="text-zinc-500 text-sm mb-6 leading-relaxed flex-grow">{{ $promo->description }}</p>
                
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-3xl font-bold text-green-500">{{ $promo->price_text }}</span>
                    <button class="px-6 py-2 bg-zinc-900 dark:bg-white dark:text-black text-white rounded-xl font-bold text-sm hover:bg-green-600 dark:hover:bg-green-500 transition-colors">
                        Aprovechar
                    </button>
                </div>
            </div>
        </div>
        
        @empty
        {{-- Mensaje por si no hay ninguna promoción activa o todas caducaron --}}
        <div class="col-span-full text-center py-16 bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800/50 rounded-[40px]">
            <span class="text-5xl block mb-4">😔</span>
            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Sin promociones por ahora</h3>
            <p class="text-zinc-500">Estamos cocinando nuevas ofertas para ti. ¡Regresa pronto!</p>
        </div>
        @endforelse

    </div>

    @guest
    <div class="mt-20 p-10 bg-green-600 rounded-[40px] flex flex-col md:flex-row items-center justify-between gap-8">
        <div>
            <h2 class="text-3xl font-bold text-black mb-2">¿No quieres perderte ninguna?</h2>
            <p class="text-green-100">Suscríbete para recibir nuestras ofertas flash directamente en tu correo.</p>
        </div>
        <div class="flex w-full md:w-auto gap-2">
            <input type="email" placeholder="tu@correo.com" class="flex-grow md:w-64 p-4 rounded-2xl bg-white/20 border border-white/30 text-white placeholder-green-100 outline-none focus:ring-2 focus:ring-white">
            <button class="bg-black text-white px-8 py-4 rounded-2xl font-bold hover:bg-zinc-800 transition">Unirme</button>
        </div>
    </div>
    @endguest
</div>
@endsection