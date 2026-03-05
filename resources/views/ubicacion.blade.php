@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-6">
    <div class="text-center mb-10">
        <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">Ubicacion</h1>
        <p class="text-zinc-500 text-lg">Ven a visitarnos</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="relative w-full h-[500px] rounded-[40px] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl">
            @php
                $mapUrlSetting = \App\Models\Setting::where('key', 'map_url')->value('value');
                // Si por alguna razón la BD está vacía, usamos un mapa genérico para que no se rompa la vista
                $finalMapUrl = $mapUrlSetting ?: 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10000!2d-98.42!3d21.14!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2smx';
            @endphp

            <iframe 
                src="{{ $finalMapUrl }}" 
                class="absolute inset-0 w-full h-full border-0 grayscale-[0.2] dark:invert-[0.9] dark:hue-rotate-[180deg]" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="flex flex-col gap-6">
            <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 p-8 rounded-[32px] shadow-lg">
                <div class="flex items-center gap-3 text-green-500 mb-4">
                    <span class="text-xl">📍</span>
                    <h2 class="text-xl font-bold dark:text-white">Direccion</h2>
                </div>
                @php
                    $addr1 = \App\Models\Setting::where('key', 'address_line1')->value('value') ?: 'Av. Deportiva #501';
                    $addr2 = \App\Models\Setting::where('key', 'address_line2')->value('value') ?: 'Col. Centro';
                    $addr3 = \App\Models\Setting::where('key', 'address_line3')->value('value') ?: 'CP 43000, Huejutla de Reyes, Hgo.';
                @endphp

                <div class="space-y-2">
                    <p class="text-lg font-bold dark:text-white">{{ $addr1 }}</p>
                    
                    @if($addr2)
                        <p class="text-zinc-500">{{ $addr2 }}</p>
                    @endif
                    
                    @if($addr3)
                        <p class="text-zinc-500">{{ $addr3 }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 p-8 rounded-[32px] shadow-lg">
                <div class="flex items-center gap-3 text-green-500 mb-6">
                    <span class="text-xl">🕒</span>
                    <h2 class="text-xl font-bold dark:text-white">Horario</h2>
                </div>
                
                @php
                    // Array con los días para iterar y no repetir código
                    $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
                @endphp

                <div class="space-y-4">
                    @foreach($dias as $index => $dia)
                        @php 
                            $key = 'schedule_' . strtolower($dia);
                            $horario = \App\Models\Setting::where('key', $key)->value('value') ?: '12:30 PM – 10:30 PM';
                            $isLast = $index === array_key_last($dias);
                        @endphp
                        
                        <div class="flex justify-between items-center {{ !$isLast ? 'pb-2 border-b border-zinc-100 dark:border-zinc-800' : '' }}">
                            <span class="text-zinc-500">{{ $dia }}</span>
                            <span class="font-medium {{ strtolower($horario) == 'cerrado' ? 'text-red-500' : 'dark:text-white' }}">
                                {{ $horario }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection