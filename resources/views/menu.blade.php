@extends('layouts.app')

@section('content')
{{-- Inicializamos el componente con x-init para que empiece a escuchar los cambios --}}
<div x-data="menuManager()" x-init="initMenu()" class="max-w-7xl mx-auto py-12 px-6">
    
    <div class="text-center mb-12 relative">
        <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">Nuestro Menú</h1>
        <p class="text-zinc-500 text-lg">Descubre todo lo que tenemos preparado para ti</p>
    </div>

    {{-- Filtros del Menú --}}
    <div class="flex justify-center gap-3 mb-10 overflow-x-auto pb-4 custom-scrollbar">
        <button @click="filtro = 'Platillos'" :class="filtro === 'Platillos' ? 'bg-green-600 text-white shadow-lg shadow-green-600/30' : 'bg-white dark:bg-[#1a1612] text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-800 hover:border-green-500/50'" class="px-8 py-3 rounded-full font-bold transition-all flex items-center gap-2 whitespace-nowrap">
            🍴 Platillos
        </button>
        <button @click="filtro = 'Bebidas'" :class="filtro === 'Bebidas' ? 'bg-green-600 text-white shadow-lg shadow-green-600/30' : 'bg-white dark:bg-[#1a1612] text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-800 hover:border-green-500/50'" class="px-8 py-3 rounded-full font-bold transition-all flex items-center gap-2 whitespace-nowrap">
            🍹 Bebidas
        </button>
        <button @click="filtro = 'Postres'" :class="filtro === 'Postres' ? 'bg-green-600 text-white shadow-lg shadow-green-600/30' : 'bg-white dark:bg-[#1a1612] text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-800 hover:border-green-500/50'" class="px-8 py-3 rounded-full font-bold transition-all flex items-center gap-2 whitespace-nowrap">
            🍰 Postres
        </button>
    </div>

    {{-- LISTA DE PRODUCTOS (Se actualiza sola gracias a Alpine) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        
        <template x-for="item in productosFiltrados()" :key="item.id">
            <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800/50 rounded-[32px] p-5 flex flex-col shadow-sm hover:shadow-xl transition-all duration-500 relative group">
                
                {{-- Contenedor de Imagen y Precio Flotante --}}
                <div class="w-full h-56 rounded-[24px] bg-zinc-100 dark:bg-black/40 mb-5 overflow-hidden shrink-0 relative">
                    {{-- Precio flotante --}}
                    <div class="absolute top-4 right-4 bg-white/90 dark:bg-black/80 backdrop-blur-sm text-green-600 dark:text-green-400 font-extrabold px-4 py-1.5 rounded-full text-sm shadow-lg z-10 transition-all duration-300" x-text="'$' + item.price"></div>

                    <template x-if="item.image">
                        <img :src="'/storage/' + item.image" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </template>
                    <template x-if="!item.image">
                        <div class="w-full h-full flex items-center justify-center text-6xl">🍔</div>
                    </template>
                </div>

                {{-- Nombre y descripción --}}
                <div class="flex-grow px-1 mb-2">
                    <h3 class="font-extrabold text-xl text-zinc-900 dark:text-white mb-2 transition-colors duration-300" x-text="item.name"></h3>
                    <p class="text-zinc-500 text-sm line-clamp-3 leading-relaxed transition-colors duration-300" x-text="item.description || 'Delicioso platillo preparado al momento con los mejores ingredientes.'"></p>
                </div>
            </div>
        </template>

        {{-- Mensaje si no hay productos --}}
        <div x-show="productosFiltrados().length === 0" class="col-span-full text-center py-20 bg-white dark:bg-[#1a1612] rounded-[40px] border border-zinc-200 dark:border-zinc-800 shadow-sm" style="display: none;">
            <span class="text-6xl block mb-4">🍽️</span>
            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Aún no hay platillos aquí</h3>
            <p class="text-zinc-500">Estamos cocinando nuevas opciones para esta categoría.</p>
        </div>

    </div>
</div>

<script>
    function menuManager() {
        return {
            filtro: 'Platillos', 
            allProductos: @json($products ?? []), 
            lastDataHash: '',

            initMenu() {
                this.lastDataHash = JSON.stringify(this.allProductos);

                setInterval(() => {
                    this.fetchLiveProducts();
                }, 5000); 
            },

            async fetchLiveProducts() {
                try {
                    const timestamp = new Date().getTime();
                    const url = `{{ route('api.menu.products') }}?t=${timestamp}`;
                    
                    const response = await fetch(url, {
                        cache: 'no-store',
                        headers: {
                            'Pragma': 'no-cache',
                            'Cache-Control': 'no-cache'
                        }
                    });

                    if (response.ok) {
                        const nuevosProductos = await response.json();
                        const newHash = JSON.stringify(nuevosProductos);

                        if (this.lastDataHash !== newHash) {
                            this.allProductos = nuevosProductos;
                            this.lastDataHash = newHash;
                        }
                    }
                } catch (e) {
                    console.error("Error obteniendo el menú en vivo:", e);
                }
            },

            productosFiltrados() {
                return this.allProductos.filter(p => p.category === this.filtro);
            }
        }
    }
</script>
@endsection