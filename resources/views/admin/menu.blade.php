@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto min-h-screen bg-zinc-50 dark:bg-[#0a0a0a] text-zinc-900 dark:text-white transition-colors duration-300">
    <div x-data="{ 
            openModal: false, 
            isEdit: false,
            filter: 'todos',
            action: '{{ route('admin.menu.store') }}',
            productData: { id: '', name: '', description: '', price: '', category: 'Platillos', available: 1 },
            ingredients: [''],
            imagePreview: null,

            loadProduct(product, ingredientList) {
                this.isEdit = true;
                this.openModal = true;
                this.action = `/admin/menu/${product.id}`;
                this.productData = { ...product };
                this.productData.available = Boolean(product.available);
                this.ingredients = ingredientList.length > 0 ? ingredientList : [''];
                this.imagePreview = product.image ? `/storage/${product.image}` : null;
            },
            resetForm() {
                this.isEdit = false;
                this.action = '{{ route('admin.menu.store') }}';
                this.productData = { id: '', name: '', description: '', price: '', category: 'Platillos', available: 1 };
                this.ingredients = [''];
                this.imagePreview = null;
            }
        }">
        
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-extrabold">Gestionar Menú</h1>
            <button @click="resetForm(); openModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20">
                + Agregar Platillo
            </button>
        </div>

        <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
            <button @click="filter = 'todos'" 
                :class="filter === 'todos' ? 'bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20' : 'bg-white dark:bg-white/5 text-zinc-500 border border-zinc-200 dark:border-white/10'"
                class="px-6 py-2 rounded-xl font-bold transition-all duration-300 whitespace-nowrap">
                Todos
            </button>
            <button @click="filter = 'Platillos'" 
                :class="filter === 'Platillos' ? 'bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20' : 'bg-white dark:bg-white/5 text-zinc-500 border border-zinc-200 dark:border-white/10'"
                class="px-6 py-2 rounded-xl font-bold transition-all duration-300 whitespace-nowrap">
                🍽️ Platillos
            </button>
            <button @click="filter = 'Bebidas'" 
                :class="filter === 'Bebidas' ? 'bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20' : 'bg-white dark:bg-white/5 text-zinc-500 border border-zinc-200 dark:border-white/10'"
                class="px-6 py-2 rounded-xl font-bold transition-all duration-300 whitespace-nowrap">
                🥤 Bebidas
            </button>
            <button @click="filter = 'Postres'" 
                :class="filter === 'Postres' ? 'bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20' : 'bg-white dark:bg-white/5 text-zinc-500 border border-zinc-200 dark:border-white/10'"
                class="px-6 py-2 rounded-xl font-bold transition-all duration-300 whitespace-nowrap">
                🍰 Postres
            </button>
        </div>

        <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-white/5 rounded-[40px] p-8 space-y-4 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <span class="text-xl">🍴</span>
                <h2 class="font-bold">Platillos</h2>
            </div>

            @foreach($products as $product)
            <div x-show="filter === 'todos' || filter === '{{ $product->category }}'" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="flex justify-between items-center p-6 bg-zinc-50 dark:bg-black/20 rounded-3xl border border-zinc-100 dark:border-white/5 hover:border-green-500/30 transition-all duration-300 mb-4">
                
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-14 h-14 rounded-2xl object-cover">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-3">
                                <div class="relative flex h-3 w-3">
                                    @if($product->available)
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-20"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]"></span>
                                    @else
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-zinc-400 dark:bg-zinc-600"></span>
                                    @endif
                                </div>

                                <h3 class="font-bold text-lg {{ $product->available ? '' : 'text-zinc-400 line-through decoration-1' }}">
                                    {{ $product->name }}
                                </h3>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-zinc-200 dark:bg-white/10 text-zinc-500 uppercase font-bold">
                                {{ $product->category }}
                            </span>
                        </div>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">${{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <button @click="loadProduct({{ $product }}, {{ $product->ingredientes->pluck('nombre') }})"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-white/5 border border-zinc-200 dark:border-white/10 text-zinc-400 hover:text-blue-500 transition-all">
                        ✏️
                    </button>
                    
                    <form action="{{ route('admin.menu.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Eliminar platillo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-white/5 border border-zinc-200 dark:border-white/10 text-zinc-400 hover:text-red-500 hover:border-red-500/50 transition-all">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

            @if($products->isEmpty())
                <div class="text-center py-20">
                    <span class="text-5xl block mb-4">Vacio</span>
                    <p class="text-zinc-500">No hay platillos registrados aún.</p>
                </div>
            @endif
        </div>

        @include('admin.partials.modal-nuevo-platillo')
    </div>
</div>
@endsection