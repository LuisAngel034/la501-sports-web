<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Repartidor - La 501</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: { colors: { darkBg: '#0a0a0a', cardBg: '#1a1612' } }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> 
        body { -webkit-tap-highlight-color: transparent; } 
    </style>
</head>
<body class="bg-zinc-100 dark:bg-darkBg text-zinc-900 dark:text-white min-h-screen pb-24"
      x-data="{ 
          // Recarga la página cada 30 segundos automáticamente
          init() { setInterval(() => { window.location.reload(); }, 30000); } 
      }">

    {{-- HEADER EXCLUSIVO DEL REPARTIDOR --}}
    <header class="sticky top-0 z-50 bg-white/90 dark:bg-black/90 backdrop-blur-md border-b border-zinc-200 dark:border-white/5 px-4 py-3 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            @php
                $logoSetting = \App\Models\Setting::where('key', 'logo')->first();
                $logoSrc = ($logoSetting && str_starts_with($logoSetting->value, 'logos/')) 
                            ? asset('storage/' . $logoSetting->value) 
                            : asset('images/logo_501.png');
            @endphp
            <img src="{{ $logoSrc }}" alt="Logo" class="h-10 w-auto rounded-lg">
            <div>
                <h1 class="font-black text-sm leading-none tracking-tight">Entregas Activas</h1>
                <p class="text-[10px] text-zinc-500 uppercase font-bold flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
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

    {{-- LISTA DE PEDIDOS --}}
    <main class="p-4 max-w-md mx-auto mt-2 space-y-6">
        
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-2xl text-center font-black text-sm shadow-lg shadow-green-500/30">
                ✅ {{ session('success') }}
            </div>
        @endif

        @forelse($orders as $order)
            <div class="bg-white dark:bg-cardBg border border-zinc-200 dark:border-white/5 rounded-[32px] p-1 shadow-md relative overflow-hidden">
                
                {{-- CABECERA DEL PEDIDO (Monto a cobrar) --}}
                <div class="bg-green-500 text-white rounded-[28px] p-5 pb-6 text-center shadow-inner">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Total a Cobrar (Efectivo)</p>
                    <p class="text-4xl font-black">${{ number_format($order->total, 2) }}</p>
                </div>

                {{-- INFORMACIÓN DEL CLIENTE --}}
                <div class="px-5 pt-4 pb-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Orden #{{ $order->id }}</p>
                            <h2 class="text-xl font-black leading-tight">{{ $order->customer_name }}</h2>
                        </div>
                    </div>

                    <p class="text-sm font-medium mb-4 flex items-start gap-2 text-zinc-600 dark:text-zinc-300 bg-zinc-50 dark:bg-black/30 p-3 rounded-2xl">
                        <span class="text-lg">📍</span> {{ $order->customer_address }}
                    </p>

                    {{-- BOTONES DE CONTACTO EN LA CALLE --}}
                    <div class="flex gap-2 mb-6">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer_address) }}" target="_blank" class="flex-1 bg-orange-500/10 text-orange-500 flex flex-col items-center justify-center py-3 rounded-2xl font-bold text-xs active:scale-95 transition">
                            <span class="text-xl mb-1">🗺️</span> Mapa
                        </a>
                        <a href="tel:{{ $order->customer_phone }}" class="flex-1 bg-blue-500/10 text-blue-500 flex flex-col items-center justify-center py-3 rounded-2xl font-bold text-xs active:scale-95 transition">
                            <span class="text-xl mb-1">📞</span> Llamar
                        </a>
                        <a href="https://wa.me/52{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="flex-1 bg-green-500/10 text-green-500 flex flex-col items-center justify-center py-3 rounded-2xl font-bold text-xs active:scale-95 transition">
                            <span class="text-xl mb-1">💬</span> Chat
                        </a>
                    </div>

                    {{-- LISTA DE PRODUCTOS CON IMÁGENES --}}
                    <div class="border-t border-zinc-200 dark:border-white/10 pt-4 mb-4">
                        <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Contenido del Pedido:</p>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-3 bg-zinc-50 dark:bg-black/20 p-2 rounded-2xl">
                                    {{-- Intenta buscar la imagen del producto en el Menú. Si no hay, pone un icono por defecto --}}
                                    @php
                                        // Busca si el producto existe en el menú para sacar su imagen
                                        $productoOriginal = \App\Models\Product::where('name', $item->product_name)->first();
                                        $imagenSrc = ($productoOriginal && $productoOriginal->image) 
                                                     ? asset('storage/' . $productoOriginal->image) 
                                                     : 'https://cdn-icons-png.flaticon.com/512/3075/3075977.png'; // Icono de hamburguesa de repuesto
                                    @endphp
                                    <img src="{{ $imagenSrc }}" alt="{{ $item->product_name }}" class="w-12 h-12 rounded-xl object-cover bg-white shadow-sm">
                                    
                                    <div class="flex-1">
                                        <p class="text-sm font-bold leading-tight">{{ $item->product_name }}</p>
                                        <p class="text-xs text-zinc-500">Cantidad: <span class="font-black text-zinc-900 dark:text-white">{{ $item->quantity }}</span></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- BOTÓN DE ENTREGADO --}}
                    <form action="{{ route('repartidor.deliver', $order->id) }}" method="POST" onsubmit="return confirm('¿Confirmas que ya entregaste el pedido y cobraste los ${{ number_format($order->total, 2) }}?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-500/30 active:scale-95 transition-transform flex justify-center items-center gap-2 text-lg">
                            <span>✅</span> MARCAR ENTREGADO
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-20 text-center opacity-40 mt-10">
                <span class="text-7xl mb-6">🛵</span>
                <h3 class="text-2xl font-black mb-1">Todo limpio</h3>
                <p class="text-sm font-medium">No hay pedidos para entregar en este momento.</p>
            </div>
        @endforelse

    </main>
</body>
</html>