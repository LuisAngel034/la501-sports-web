<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Mesero - La 501</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { darkBg: '#0a0a0a', cardBg: '#1a1612' } } }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { -webkit-tap-highlight-color: transparent; } </style>
</head>
<body class="bg-zinc-100 dark:bg-darkBg text-zinc-900 dark:text-white min-h-screen pb-24" x-data="{ showModal: false, nuevaMesa: '' }">

    {{-- HEADER DEL MESERO --}}
    <header class="sticky top-0 z-50 bg-white/90 dark:bg-black/90 backdrop-blur-md border-b border-zinc-200 dark:border-white/5 px-4 py-3 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <span class="text-2xl">📝</span>
            <div>
                <h1 class="font-black text-sm leading-none tracking-tight">Mesas Activas</h1>
                <p class="text-[10px] text-zinc-500 uppercase font-bold flex items-center gap-1">
                    {{ Auth::user()->name }}
                </p>
            </div>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition rounded-xl px-4 py-2 text-xs font-black flex items-center gap-2">
                🚪 Salir
            </button>
        </form>
    </header>

    <main class="p-4 max-w-md mx-auto mt-2 space-y-6">
        
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-2xl text-center font-black text-sm shadow-lg shadow-green-500/30">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- BOTÓN GIGANTE PARA NUEVA MESA --}}
        <button @click="showModal = true" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-[24px] shadow-xl shadow-blue-500/30 active:scale-95 transition-transform flex justify-center items-center gap-2 text-lg">
            <span>➕</span> ABRIR NUEVA MESA
        </button>

        {{-- LISTA DE MESAS OCUPADAS --}}
        <div>
            <h2 class="text-xs font-black text-zinc-500 uppercase tracking-widest mb-4 pl-2">Cuentas Abiertas</h2>
            
            <div class="grid grid-cols-2 gap-4">
                @forelse($mesasOcupadas as $numeroMesa => $pedidos)
                    @php 
                        // Sumamos el total de todo lo que ha pedido esta mesa
                        $totalMesa = $pedidos->sum('total'); 
                    @endphp
                    
                    <div class="bg-white dark:bg-cardBg border border-zinc-200 dark:border-white/5 rounded-[24px] p-4 shadow-sm flex flex-col justify-between">
                        <div class="mb-4">
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Mesa</p>
                            <h3 class="text-3xl font-black leading-none">{{ $numeroMesa }}</h3>
                            <p class="text-sm font-bold text-green-500 mt-2">${{ number_format($totalMesa, 2) }}</p>
                        </div>
                        
                        <div class="flex gap-2">
                            {{-- Botón para agregar más cosas --}}
                            <a href="{{ route('mesero.pedido', $numeroMesa) }}" class="flex-1 bg-zinc-100 dark:bg-black text-center py-2 rounded-xl font-bold text-xs hover:bg-zinc-200 transition">
                                📝 Agregar
                            </a>
                            {{-- Botón para cobrar --}}
                            <form action="{{ route('mesero.cobrar', $numeroMesa) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Confirmas que la Mesa {{ $numeroMesa }} pagó ${{ number_format($totalMesa, 2) }} en efectivo?');">
                                @csrf @method('PUT')
                                <button type="submit" class="w-full bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white text-center py-2 rounded-xl font-bold text-xs transition">
                                    💵 Cobrar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 flex flex-col items-center justify-center py-10 text-center opacity-40">
                        <span class="text-5xl mb-4">🍽️</span>
                        <p class="text-sm font-bold">No hay mesas ocupadas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    {{-- MODAL PARA INGRESAR EL NÚMERO DE MESA --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4" style="display: none;" x-transition>
        <div @click.away="showModal = false" class="bg-white dark:bg-[#1a1612] w-full max-w-sm rounded-[32px] p-6 shadow-2xl text-center border border-zinc-200 dark:border-white/10">
            <h2 class="text-xl font-black text-zinc-900 dark:text-white mb-2">Nueva Mesa</h2>
            <p class="text-xs text-zinc-500 mb-6">Ingresa el número de la mesa para tomar su pedido.</p>
            
            <div class="mb-6">
                <input type="number" x-model="nuevaMesa" placeholder="Ej. 12" class="w-full bg-zinc-100 dark:bg-black border border-zinc-200 dark:border-white/10 rounded-2xl px-4 py-4 text-3xl font-black text-center text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="flex gap-3">
                <button @click="showModal = false" class="flex-1 py-3 rounded-xl font-bold text-zinc-500 bg-zinc-100 dark:bg-white/5 transition">Cancelar</button>
                
                {{-- Redirige a la pantalla de tomar pedido usando el número ingresado --}}
                <a :href="'/mesero/mesas/' + nuevaMesa + '/pedido'" class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition shadow-lg flex justify-center items-center">
                    Continuar
                </a>
            </div>
        </div>
    </div>

</body>
</html>