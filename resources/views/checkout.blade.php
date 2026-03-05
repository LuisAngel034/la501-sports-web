@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-zinc-900 dark:text-white mb-2">Finalizar Pedido</h1>
        <p class="text-zinc-500">Ingresa tus datos para la entrega</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 rounded-[32px] shadow-xl overflow-hidden">
        @csrf
        
        <div class="p-8 space-y-6">
            {{-- Datos de Contacto --}}
            <div>
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Datos de Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Nombre Completo</label>
                        <input type="text" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required 
                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Teléfono</label>
                        <input type="tel" name="customer_phone" required placeholder="10 dígitos"
                            class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none">
                    </div>
                </div>
            </div>

            {{-- Dirección --}}
            <div>
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Dirección de Entrega</h3>
                <div>
                    <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Calle, Número, Colonia y Referencia</label>
                    <textarea name="customer_address" required rows="2" placeholder="Ej. Av. Principal 123, Col. Centro. Casa blanca con portón negro."
                        class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none resize-none"></textarea>
                </div>
            </div>

            {{-- Método de Pago --}}
            <div>
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Método de Pago</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="flex items-center justify-between p-4 border border-zinc-200 dark:border-zinc-800 rounded-2xl cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-500/10">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">💵</span>
                            <span class="font-bold dark:text-white">Efectivo al recibir</span>
                        </div>
                        <input type="radio" name="payment_method" value="efectivo" required class="w-5 h-5 accent-green-600">
                    </label>

                    <label class="flex items-center justify-between p-4 border border-zinc-200 dark:border-zinc-800 rounded-2xl cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-500/10">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">💳</span>
                            <span class="font-bold dark:text-white">Tarjeta</span>
                        </div>
                        <input type="radio" name="payment_method" value="tarjeta" required class="w-5 h-5 accent-green-600">
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-zinc-50 dark:bg-black/20 p-6 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <span class="text-zinc-500 font-bold uppercase text-xs block">Total a Pagar</span>
                <span class="text-3xl font-extrabold text-green-600 dark:text-green-500">${{ number_format($total, 2) }}</span>
            </div>
            
            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-green-600 hover:bg-green-500 text-black font-bold rounded-2xl shadow-lg transition-transform active:scale-95">
                Confirmar Pedido
            </button>
        </div>
    </form>
</div>
@endsection