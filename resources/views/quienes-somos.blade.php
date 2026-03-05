@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-16 px-6">
    
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold mb-6 text-zinc-900 dark:text-white font-bold">Quienes Somos</h1>
        <p class="text-zinc-500 dark:text-zinc-400 max-w-3xl mx-auto text-lg">
            Bienvenidos a Restaurant La 501 Sports, donde la pasión por el deporte y la buena comida se unen para crear momentos inolvidables en familia.
        </p>
    </div>

    <div class="relative overflow-hidden bg-zinc-100 dark:bg-gradient-to-r dark:from-zinc-900 dark:via-zinc-900 dark:to-green-900/40 p-12 md:p-20 rounded-[40px] mb-16 border border-zinc-200 dark:border-zinc-800/50">
        <div class="max-w-2xl relative z-10">
            <h2 class="text-4xl font-bold mb-6 leading-tight text-zinc-900 dark:text-white">Más que un restaurante, somos tu segundo hogar</h2>
            <p class="text-zinc-600 dark:text-zinc-400 text-lg leading-relaxed">
                Desde 20XX, hemos sido el lugar favorito de familias y amigos para disfrutar de los mejores partidos mientras saborean nuestra deliciosa comida. Nuestro ambiente combina la emoción del deporte con la calidez de un hogar.
            </p>
        </div>
        <div class="absolute right-0 top-0 w-1/3 h-full bg-green-600/10 blur-[100px] rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-24">
        @php
            $valores = [
                ['titulo' => 'Amor Familiar', 'icon' => '❤️', 'desc' => 'Creamos un ambiente acogedor donde las familias pueden disfrutar juntas.'],
                ['titulo' => 'Pasión Deportiva', 'icon' => '🏆', 'desc' => 'Pantallas HD para que no te pierdas ningún momento de tus equipos favoritos.'],
                ['titulo' => 'Sabor Casero', 'icon' => '🍴', 'desc' => 'Recetas tradicionales preparadas con ingredientes frescos y mucho cariño.'],
                ['titulo' => 'Comunidad', 'icon' => '👥', 'desc' => 'Un lugar donde vecinos y amigos se reúnen para celebrar juntos.'],
            ];
        @endphp

        @foreach($valores as $v)
        <div class="bg-white dark:bg-zinc-900/30 p-10 rounded-3xl border border-zinc-200 dark:border-zinc-800/50 text-center hover:border-green-500/50 transition-all duration-300 group shadow-sm dark:shadow-none">
            <div class="bg-zinc-100 dark:bg-zinc-800 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                <span class="text-green-500 text-2xl">{{ $v['icon'] }}</span>
            </div>
            <h3 class="text-xl font-bold mb-4 text-zinc-900 dark:text-white">{{ $v['titulo'] }}</h3>
            <p class="text-zinc-500 dark:text-zinc-500 text-sm leading-relaxed">{{ $v['desc'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center border-t border-zinc-200 dark:border-zinc-800/50 pt-20">
        <div class="space-y-8">
            <h2 class="text-4xl font-bold italic text-zinc-900 dark:text-white">Nuestra Historia</h2>
            <div class="space-y-6 text-zinc-600 dark:text-zinc-400 text-lg leading-relaxed">
                <p>Historia...</p>
                <p>Historia...</p>
                <p>Historia...</p>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-green-600 to-emerald-600 rounded-[40px] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
            <div class="relative aspect-video lg:aspect-square bg-zinc-200 dark:bg-zinc-900 rounded-[40px] overflow-hidden border border-zinc-200 dark:border-zinc-800 flex items-center justify-center">
                <img src="{{ asset('images/NH.jpg') }}" alt="Nuestra Historia" class="absolute inset-0 w-full h-full object-cover opacity-80 dark:opacity-60 group-hover:scale-105 transition duration-700">
                
                <div class="relative z-10 text-center bg-white/60 dark:bg-black/40 backdrop-blur-md p-8 rounded-full border border-zinc-200 dark:border-white/10">
                    <div class="text-green-600 dark:text-green-500 text-4xl mb-2">🍴</div>
                    <div class="text-4xl font-bold text-zinc-900 dark:text-white">XX Años</div>
                    <div class="text-zinc-700 dark:text-zinc-300 text-sm">Sirviendo a nuestra comunidad</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection