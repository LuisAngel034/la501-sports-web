@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="text-center mb-10">
        <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">Tu Pedido</h1>
        <p class="text-zinc-500 text-lg">Revisa tu orden antes de proceder al pago</p>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 p-4 rounded-2xl mb-8 text-center font-bold">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- MENSAJE DE ERROR/ALERTA (Productos agotados) --}}
    @if(session('error'))
        <div class="max-w-3xl mx-auto bg-red-500/10 border border-red-500/20 text-red-500 dark:text-red-400 p-4 rounded-2xl mb-10 text-center font-bold flex items-center justify-center gap-2">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @if(count((array) session('cart')) > 0)
        <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 rounded-[40px] shadow-xl overflow-hidden">
            <div class="p-8">
                <div class="space-y-6">
                    @foreach(session('cart') as $id => $details)
                        <div class="flex flex-col sm:flex-row items-center gap-4 pb-6 border-b border-zinc-100 dark:border-zinc-800/50 last:border-0 last:pb-0">
                            
                            {{-- Imagen del platillo --}}
                            <div class="w-20 h-20 rounded-2xl bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex-shrink-0">
                                @if($details['image'])
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl">🍔</div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-grow text-center sm:text-left w-full sm:w-auto">
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white">{{ $details['name'] }}</h3>
                                <p class="text-zinc-500 text-sm">${{ number_format($details['price'], 2) }} c/u</p>
                            </div>

                            {{-- Controles de Cantidad (+ / -) --}}
                            <div class="flex items-center gap-2">
                                {{-- Botón Restar --}}
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                    <button type="submit" class="bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-500 h-10 w-10 rounded-xl font-extrabold flex items-center justify-center transition-colors">
                                        -
                                    </button>
                                </form>

                                {{-- Cantidad Actual --}}
                                <div class="w-12 text-center font-bold text-zinc-900 dark:text-white">
                                    {{ $details['quantity'] }}
                                </div>

                                {{-- Botón Sumar --}}
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                    <button type="submit" class="bg-green-100 hover:bg-green-200 dark:bg-green-500/20 dark:hover:bg-green-500/30 text-green-600 h-10 w-10 rounded-xl font-extrabold flex items-center justify-center transition-colors">
                                        +
                                    </button>
                                </form>
                            </div>

                            {{-- Subtotal y Botón Eliminar --}}
                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-4 mt-2 sm:mt-0">
                                <div class="text-right">
                                    <p class="font-bold text-lg text-green-500">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                </div>

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-zinc-400 hover:text-red-500 bg-zinc-50 hover:bg-red-50 dark:bg-zinc-800/50 dark:hover:bg-red-500/10 transition p-2.5 rounded-xl" title="Quitar producto">
                                        🗑️
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sección de Total y Pagar --}}
            <div class="bg-zinc-50 dark:bg-black/20 p-8 border-t border-zinc-200 dark:border-zinc-800">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-zinc-500 font-bold uppercase tracking-wider">Total a Pagar</span>
                    <span class="text-4xl font-extrabold text-zinc-900 dark:text-white">${{ number_format($total, 2) }}</span>
                </div>

                {{-- Beneficio de estar logueado --}}
                @auth
                    <div class="bg-blue-500/10 border border-blue-500/20 text-blue-500 p-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                        <span>✨</span> Estás acumulando <strong>{{ floor($total / 10) }} Puntos La 501</strong> con esta compra.
                    </div>
                @else
                    <div class="bg-yellow-500/10 border border-yellow-500/20 text-yellow-600 p-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                        <span>💡</span> <a href="{{ route('login') }}" class="font-bold underline">Inicia sesión</a> para acumular puntos con esta compra.
                    </div>
                @endauth

                <div class="flex flex-col sm:flex-row gap-4">
                    <form action="{{ route('cart.clear') }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full px-6 py-4 rounded-2xl font-bold text-zinc-500 border border-zinc-200 dark:border-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                            Vaciar Carrito
                        </button>
                    </form>
                    
                    {{-- Este botón nos llevará a la pasarela de pago (Checkout) --}}
                    <a href="{{ route('checkout.index') }}" class="flex-1 text-center py-4 bg-green-600 hover:bg-green-500 text-black font-bold rounded-2xl shadow-lg shadow-green-900/20 transition-all transform active:scale-[0.98]">
                        Proceder al Pago
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Si el carrito está vacío --}}
        <div class="text-center bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 rounded-[40px] p-16 shadow-xl">
            <span class="text-6xl block mb-4">🛒</span>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Tu carrito está vacío</h2>
            <p class="text-zinc-500 mb-8">Parece que aún no has agregado nada delicioso a tu pedido.</p>
            <a href="/a-domicilio" class="inline-block bg-green-600 text-black px-8 py-3 rounded-2xl font-bold hover:bg-green-500 transition">
                Ver Menú
            </a>
        </div>
    @endif
</div>
@endsection