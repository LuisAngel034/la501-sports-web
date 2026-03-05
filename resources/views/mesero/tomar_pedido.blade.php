<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Tomar Pedido - Mesa {{ $mesaId }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { -webkit-tap-highlight-color: transparent; } </style>
</head>
<body class="bg-zinc-100 dark:bg-[#0a0a0a] text-zinc-900 dark:text-white min-h-screen pb-32"
      x-data="carritoPedido()">

    {{-- HEADER CON BOTÓN DE REGRESAR --}}
    <header class="sticky top-0 z-50 bg-white/90 dark:bg-black/90 backdrop-blur-md border-b border-zinc-200 dark:border-white/5 px-4 py-3 flex items-center shadow-sm gap-4">
        <a href="{{ route('mesero.mesas') }}" class="p-2 bg-zinc-100 dark:bg-white/10 rounded-full hover:bg-zinc-200 transition">
            🔙
        </a>
        <div>
            <h1 class="font-black text-lg leading-none">Mesa {{ $mesaId }}</h1>
            <p class="text-[10px] text-zinc-500 uppercase font-bold">Tomando Orden</p>
        </div>
    </header>

    <main class="p-4 max-w-md mx-auto space-y-8 mt-2">
        {{-- BUCLE DE CATEGORÍAS Y PRODUCTOS --}}
        @foreach($menu as $categoria => $productos)
            <div>
                <h2 class="text-sm font-black text-zinc-500 uppercase tracking-widest mb-4 pl-2 border-l-4 border-blue-500">{{ $categoria }}</h2>
                <div class="space-y-3">
                    @foreach($productos as $producto)
                        <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-white/5 rounded-[24px] p-3 shadow-sm flex items-center gap-4">
                            {{-- IMAGEN DEL PRODUCTO --}}
                            @php
                                $imagenSrc = $producto->image ? asset('storage/' . $producto->image) : 'https://cdn-icons-png.flaticon.com/512/3075/3075977.png';
                            @endphp
                            <img src="{{ $imagenSrc }}" alt="{{ $producto->name }}" class="w-16 h-16 rounded-2xl object-cover bg-zinc-50">
                            
                            {{-- INFO Y BOTONES --}}
                            <div class="flex-1">
                                <h3 class="font-bold text-sm leading-tight">{{ $producto->name }}</h3>
                                <p class="text-green-500 font-black text-sm">${{ number_format($producto->price, 2) }}</p>
                            </div>

                            {{-- CONTROLES ALPINE PARA SUMAR/RESTAR --}}
                            <div class="flex items-center gap-3 bg-zinc-100 dark:bg-black p-1 rounded-2xl">
                                <button @click="restar({{ $producto->id }})" class="w-8 h-8 flex items-center justify-center bg-white dark:bg-[#1a1612] rounded-xl font-bold shadow-sm">-</button>
                                <span class="font-black w-4 text-center text-sm" x-text="getCantidad({{ $producto->id }})"></span>
                                <button @click="agregar({{ $producto->id }}, '{{ addslashes($producto->name) }}', {{ $producto->price }})" class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-xl font-bold shadow-sm">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </main>

    {{-- BARRA FLOTANTE INFERIOR (ENVIAR ORDEN) --}}
    <div x-show="total > 0" x-transition class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#1a1612] border-t border-zinc-200 dark:border-white/10 p-4 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] z-50" style="display: none;">
        <div class="max-w-md mx-auto flex gap-4 items-center">
            <div class="flex-1">
                <p class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest">Total a mandar</p>
                <p class="text-2xl font-black text-green-500" x-text="'$' + total.toFixed(2)"></p>
            </div>
            
            <form action="{{ route('mesero.guardar_pedido', $mesaId) }}" method="POST" class="flex-1">
                @csrf
                {{-- Aquí mandamos todo el carrito en formato texto oculto al servidor --}}
                <input type="hidden" name="carrito" :value="JSON.stringify(Object.values(items))">
                <input type="hidden" name="total" :value="total">
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-500/30 active:scale-95 transition-transform flex justify-center items-center gap-2">
                    🍽️ ENVIAR A COCINA
                </button>
            </form>
        </div>
    </div>

    {{-- Lógica de Alpine.js para el carrito --}}
    <script>
        function carritoPedido() {
            return {
                items: {},
                total: 0,
                
                agregar(id, name, price) {
                    if (this.items[id]) {
                        this.items[id].cantidad++;
                    } else {
                        this.items[id] = { id: id, name: name, price: price, cantidad: 1 };
                    }
                    this.calcularTotal();
                },
                
                restar(id) {
                    if (this.items[id] && this.items[id].cantidad > 0) {
                        this.items[id].cantidad--;
                        if (this.items[id].cantidad === 0) delete this.items[id];
                        this.calcularTotal();
                    }
                },
                
                getCantidad(id) {
                    return this.items[id] ? this.items[id].cantidad : 0;
                },

                calcularTotal() {
                    let suma = 0;
                    for (let id in this.items) {
                        suma += this.items[id].price * this.items[id].cantidad;
                    }
                    this.total = suma;
                }
            }
        }
    </script>
</body>
</html>