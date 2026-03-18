@extends('layouts.admin')

@section('content')
<div x-data="{ 
        showModal: false, 
        mesaActual: 0, 
        totalActual: 0,
        abrirCobro(mesa, total) {
            this.mesaActual = mesa;
            this.totalActual = total;
            this.showModal = true;
        }
    }">
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-zinc-900 dark:text-white uppercase tracking-wider font-['Oswald']">Mapa de Mesas</h1>
            <p class="text-zinc-500 text-sm">Gestiona los pedidos de los comensales</p>
        </div>
    </div>

    {{-- Alertas de Éxito --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            <p class="font-bold">¡Éxito!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Cuadrícula de Mesas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($mesas as $mesa)
            <div class="rounded-xl border shadow-sm transition-all duration-300 flex flex-col justify-between 
                {{ $mesa['ocupada'] ? 'bg-orange-50/50 border-orange-200 dark:bg-orange-950/20 dark:border-orange-900' : 'bg-white border-zinc-200 dark:bg-[#111111] dark:border-white/10' }} p-6">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-4xl font-black font-['Oswald'] {{ $mesa['ocupada'] ? 'text-orange-600 dark:text-orange-500' : 'text-zinc-800 dark:text-white' }}">
                            #{{ $mesa['id'] }}
                        </h2>
                        <p class="text-xs font-bold uppercase tracking-widest mt-1 {{ $mesa['ocupada'] ? 'text-orange-500' : 'text-green-500' }}">
                            {{ $mesa['ocupada'] ? 'Ocupada' : 'Disponible' }}
                        </p>
                    </div>
                    
                    @if($mesa['ocupada'])
                        <div class="text-right">
                            <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider mb-1">Total</p>
                            <p class="text-2xl font-black text-zinc-900 dark:text-white">${{ number_format($mesa['total'], 2) }}</p>
                        </div>
                    @endif
                </div>

                <div>
                    @if($mesa['ocupada'])
                        <button type="button" @click="abrirCobro({{ $mesa['id'] }}, {{ $mesa['total'] }})" 
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold uppercase tracking-wider py-3 px-4 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                            💰 Cobrar Mesa
                        </button>
                    @else
                        <a href="{{ route('mesero.pedido', $mesa['id']) }}" 
                           class="block text-center w-full bg-green-600 hover:bg-green-700 text-white font-bold uppercase tracking-wider py-3 px-4 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                            📝 Tomar Pedido
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- MODAL DE COBRO (ALpineJS) --}}
    <div x-show="showModal" style="display: none;" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        
        <div @click.away="showModal = false" 
             class="bg-white dark:bg-[#111111] border border-zinc-200 dark:border-white/10 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-black flex justify-between items-center">
                <h3 class="text-lg font-black text-zinc-900 dark:text-white uppercase tracking-wider font-['Oswald']">
                    Cobrar Mesa <span x-text="mesaActual" class="text-orange-500"></span>
                </h3>
                <button @click="showModal = false" class="text-zinc-400 hover:text-red-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Formulario dinámico que apunta a la ruta de la mesa actual --}}
            <form :action="'{{ url('mesero/mesas') }}/' + mesaActual + '/cobrar'" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <div class="text-center bg-zinc-100 dark:bg-[#1A1A1A] rounded-xl p-4 border border-zinc-200 dark:border-white/5">
                        <p class="text-sm text-zinc-500 uppercase font-bold tracking-widest mb-1">Total a Pagar</p>
                        <p class="text-5xl font-black text-green-600 dark:text-green-500">
                            $<span x-text="Number(totalActual).toFixed(2)"></span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 uppercase tracking-wide">
                            Método de Pago
                        </label>
                        <select name="payment_method" required 
                                class="w-full bg-white dark:bg-[#1A1A1A] border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-lg p-3 outline-none focus:ring-2 focus:ring-orange-500 transition font-bold">
                            <option value="efectivo">💵 Efectivo</option>
                            <option value="tarjeta">💳 Tarjeta (Terminal)</option>
                            <option value="mercadopago">📱 Transferencia / MercadoPago</option>
                        </select>
                    </div>
                </div>

                <div class="px-6 py-4 bg-zinc-50 dark:bg-black border-t border-zinc-200 dark:border-white/10 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-lg text-sm font-bold text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-800 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-green-600 hover:bg-green-700 shadow-lg shadow-green-500/30 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Confirmar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection