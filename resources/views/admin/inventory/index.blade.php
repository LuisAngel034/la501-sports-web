@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto" x-data="inventoryManager()">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Inventario de Insumos</h1>
            <p class="text-zinc-500 mt-1">Controla tus ingredientes, bebidas y suministros.</p>
        </div>
        <button @click="openCreate()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-600/20 whitespace-nowrap">
            + Nuevo Artículo
        </button>
    </div>

    {{-- Tarjetas de Resumen --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#1a1612] p-6 rounded-[24px] border border-zinc-200 dark:border-white/5 flex items-center gap-4 shadow-sm">
            <div class="bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 p-4 rounded-2xl text-2xl">📦</div>
            <div>
                <p class="text-zinc-500 text-sm font-bold uppercase">Total Artículos</p>
                <p class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ $totalItems }}</p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-[#1a1612] p-6 rounded-[24px] border border-zinc-200 dark:border-white/5 flex items-center gap-4 shadow-sm">
            <div class="bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 p-4 rounded-2xl text-2xl">⚠️</div>
            <div>
                <p class="text-zinc-500 text-sm font-bold uppercase">Stock Bajo</p>
                <p class="text-3xl font-extrabold text-red-500">{{ $lowStockCount }}</p>
            </div>
        </div>
    </div>

    {{-- Tabla de Inventario --}}
    <div class="bg-white dark:bg-[#1a1612] rounded-[32px] shadow-xl border border-zinc-200 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-white/5 text-xs uppercase tracking-wider text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-white/10">
                        <th class="p-6 font-bold">Artículo</th>
                        <th class="p-6 font-bold">Categoría</th>
                        <th class="p-6 font-bold text-center">Stock Actual</th>
                        <th class="p-6 font-bold text-center">Mínimo</th>
                        <th class="p-6 font-bold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                    @forelse($items as $item)
                        @php
                            $isLowStock = $item->current_stock <= $item->min_stock;
                        @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition group">
                            <td class="p-6">
                                <p class="font-bold text-zinc-900 dark:text-white text-base">{{ $item->name }}</p>
                            </td>
                            <td class="p-6">
                                <span class="bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 px-3 py-1 rounded-lg text-xs font-bold">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="p-6 text-center">
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl {{ $isLowStock ? 'bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20' : 'bg-green-100 dark:bg-green-500/10 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/20' }}">
                                    <span class="font-extrabold text-lg">{{ floatval($item->current_stock) }}</span>
                                    <span class="text-xs font-bold uppercase opacity-80">{{ $item->unit }}</span>
                                </div>
                            </td>
                            <td class="p-6 text-center text-zinc-500 text-sm font-bold">
                                {{ floatval($item->min_stock) }} {{ $item->unit }}
                            </td>
                            <td class="p-6">
                                <div class="flex justify-end gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                    {{-- Botón rápido para sumar/restar stock --}}
                                    <button @click="openAdjust({{ json_encode($item) }})" title="Ajustar Stock" class="bg-green-500/10 hover:bg-green-500 text-green-600 hover:text-white p-2 rounded-xl transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    </button>
                                    
                                    {{-- Botón Editar --}}
                                    <button @click="openEdit({{ json_encode($item) }})" class="bg-blue-500/10 hover:bg-blue-500 text-blue-500 hover:text-white p-2 rounded-xl transition">
                                        ✏️
                                    </button>
                                    
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este artículo del inventario?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white p-2 rounded-xl transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-zinc-500">
                                No hay artículos en el inventario. ¡Agrega el primero!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL 1: CREAR / EDITAR ARTÍCULO COMPLETO --}}
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="openModal = false"></div>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-[#1a1612] rounded-[32px] shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-zinc-200 dark:border-white/10">
                <form :action="actionUrl" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" :disabled="!isEdit">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="isEdit ? 'Editar Artículo' : 'Nuevo Artículo'"></h3>
                        <button type="button" @click="openModal = false" class="text-zinc-400 hover:text-zinc-800 dark:hover:text-white text-2xl">&times;</button>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Nombre del Artículo</label>
                            <input type="text" name="name" x-model="formData.name" required placeholder="Ej: Tomate Guaje" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Categoría</label>
                                <select name="category" x-model="formData.category" required class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white appearance-none">
                                    <option value="Carnes">🥩 Carnes</option>
                                    <option value="Verduras">🍅 Verduras</option>
                                    <option value="Bebidas">🥤 Bebidas</option>
                                    <option value="Lácteos">🧀 Lácteos</option>
                                    <option value="Panadería">🍞 Panadería</option>
                                    <option value="Abarrotes">🥫 Abarrotes</option>
                                    <option value="Limpieza">🧼 Limpieza</option>
                                    <option value="Otros">📦 Otros</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Unidad de Medida</label>
                                <select name="unit" x-model="formData.unit" required class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white appearance-none">
                                    <option value="kg">Kilogramos (kg)</option>
                                    <option value="L">Litros (L)</option>
                                    <option value="pz">Piezas (pz)</option>
                                    <option value="cajas">Cajas</option>
                                    <option value="paquetes">Paquetes</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Stock Inicial / Actual</label>
                                <input type="number" step="0.01" min="0" name="current_stock" x-model="formData.current_stock" required placeholder="0.00" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Alerta de Stock Mínimo</label>
                                <input type="number" step="0.01" min="0" name="min_stock" x-model="formData.min_stock" required placeholder="0.00" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-red-500 text-zinc-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="openModal = false" class="flex-1 px-6 py-3 rounded-xl font-bold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 transition">Cancelar</button>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL 2: AJUSTE RÁPIDO DE STOCK (+ / -) --}}
    <div x-show="openAdjustModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="openAdjustModal = false"></div>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-[#1a1612] rounded-[32px] shadow-2xl sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-zinc-200 dark:border-white/10">
                <form :action="adjustUrl" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white text-center mb-1">Ajustar Stock</h3>
                    <p class="text-center text-zinc-500 text-sm mb-6" x-text="adjustItemName"></p>

                    <div class="flex bg-zinc-100 dark:bg-white/5 p-1 rounded-2xl mb-6">
                        <label class="flex-1 text-center cursor-pointer">
                            <input type="radio" name="type" value="add" x-model="adjustType" class="peer sr-only">
                            <div class="py-2 rounded-xl text-sm font-bold text-zinc-500 peer-checked:bg-green-500 peer-checked:text-white transition">
                                + Entró
                            </div>
                        </label>
                        <label class="flex-1 text-center cursor-pointer">
                            <input type="radio" name="type" value="subtract" x-model="adjustType" class="peer sr-only">
                            <div class="py-2 rounded-xl text-sm font-bold text-zinc-500 peer-checked:bg-red-500 peer-checked:text-white transition">
                                - Salió
                            </div>
                        </label>
                    </div>

                    <div class="mb-8">
                        <label class="block text-center text-xs font-bold uppercase text-zinc-500 mb-2">Cantidad a ajustar</label>
                        <div class="relative flex items-center justify-center">
                            <input type="number" step="0.01" min="0.01" name="amount" required placeholder="0" class="w-full text-center text-4xl font-extrabold bg-transparent border-b-2 border-zinc-200 dark:border-zinc-800 focus:border-blue-500 outline-none pb-2 text-zinc-900 dark:text-white">
                            <span class="absolute right-4 bottom-3 text-zinc-400 font-bold" x-text="adjustItemUnit"></span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="openAdjustModal = false" class="flex-1 px-4 py-3 rounded-xl font-bold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 transition">Cancelar</button>
                        <button type="submit" class="flex-1 bg-zinc-900 dark:bg-white text-white dark:text-black hover:scale-105 px-4 py-3 rounded-xl font-bold shadow-lg transition">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function inventoryManager() {
        return {
            openModal: false,
            openAdjustModal: false,
            isEdit: false,
            actionUrl: '',
            formData: { name: '', category: 'Carnes', unit: 'kg', current_stock: '', min_stock: '' },

            adjustUrl: '',
            adjustItemName: '',
            adjustItemUnit: '',
            adjustType: 'add',

            openCreate() {
                this.isEdit = false;
                this.actionUrl = '{{ route("admin.inventory.store") }}';
                this.formData = { name: '', category: 'Carnes', unit: 'kg', current_stock: '', min_stock: '' };
                this.openModal = true;
            },

            openEdit(item) {
                this.isEdit = true;
                let baseUrl = '{{ route("admin.inventory.update", ":id") }}';
                this.actionUrl = baseUrl.replace(':id', item.id); 
                
                this.formData = {
                    name: item.name,
                    category: item.category,
                    unit: item.unit,
                    current_stock: item.current_stock,
                    min_stock: item.min_stock
                };
                this.openModal = true;
            },

            openAdjust(item) {
                let baseUrl = '{{ route("admin.inventory.adjust", ":id") }}';
                this.adjustUrl = baseUrl.replace(':id', item.id);
                this.adjustItemName = item.name;
                this.adjustItemUnit = item.unit;
                this.adjustType = 'add';
                this.openAdjustModal = true;
            }
        }
    }
</script>
@endsection