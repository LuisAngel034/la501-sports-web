@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto" x-data="promoManager()">
    
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Gestionar Promociones</h1>
        <button @click="openCreate()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20">
            + Nueva Promoción
        </button>
    </div>

    {{-- Grid de Promociones --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($promotions as $item)
        <div class="group relative bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800/50 rounded-[40px] overflow-hidden shadow-xl flex flex-col h-full">
            
            <div class="absolute top-4 left-4 z-10 flex gap-2">
                <button @click="openEdit({{ json_encode($item) }})" class="bg-white/90 dark:bg-black/80 backdrop-blur text-blue-500 p-2 rounded-xl shadow hover:scale-110 transition">✏️</button>
                <form action="{{ route('admin.promotions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta promoción?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-white/90 dark:bg-black/80 backdrop-blur text-red-500 p-2 rounded-xl shadow hover:scale-110 transition">🗑️</button>
                </form>
            </div>

            {{-- CONDICIÓN VISUAL: Si hay imagen la muestra, si no, usa el icono y color --}}
            <div class="h-48 relative overflow-hidden bg-zinc-100 dark:bg-zinc-800 {{ !$item->image ? 'bg-gradient-to-br ' . $item->color_gradient : '' }} flex items-center justify-center">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-6xl">{{ $item->icon }}</span>
                @endif
                
                @if($item->tag)
                <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-md px-4 py-1 rounded-full text-white font-bold text-sm italic z-10">
                    {{ $item->tag }}
                </div>
                @endif
            </div>
            
            <div class="p-8 flex flex-col flex-grow">
                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">{{ $item->title }}</h3>
                <p class="text-zinc-500 text-sm mb-6 leading-relaxed flex-grow">{{ $item->description }}</p>
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-3xl font-bold text-green-500">{{ $item->price_text }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- MODAL ÚNICO --}}
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="openModal = false"></div>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-[#1a1612] rounded-[32px] shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-zinc-200 dark:border-white/10">
                
                <form :action="actionUrl" method="POST" enctype="multipart/form-data" class="p-8" @submit="if(isSubmitting) { $event.preventDefault(); } else { isSubmitting = true; }">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" :disabled="!isEdit">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="isEdit ? 'Editar Promoción' : 'Nueva Promoción'"></h3>
                        <button type="button" @click="openModal = false" class="text-zinc-400 hover:text-zinc-800 dark:hover:text-white text-2xl">&times;</button>
                    </div>

                    <div class="space-y-6">
                        
                        {{-- IMAGEN OPCIONAL --}}
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-2 text-center">Imagen (Opcional, reemplaza el icono y color)</label>
                            <div class="flex justify-center w-full">
                                <label class="w-full max-w-sm h-32 flex flex-col items-center justify-center border-2 border-dashed border-blue-300 dark:border-blue-500/30 rounded-2xl cursor-pointer bg-blue-50/50 dark:bg-blue-900/10 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition relative overflow-hidden group">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="absolute inset-0 w-full h-full object-cover z-10 group-hover:opacity-80 transition">
                                    </template>
                                    
                                    <div x-show="!imagePreview" class="flex flex-col items-center justify-center z-0 p-4 text-center">
                                        <svg class="w-8 h-8 text-blue-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400">Subir imagen</span>
                                    </div>

                                    <template x-if="imagePreview">
                                        <div class="absolute inset-0 z-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40 backdrop-blur-sm">
                                            <span class="text-white font-bold text-xs">Cambiar imagen</span>
                                        </div>
                                    </template>

                                    <input type="file" name="image" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result; }; reader.readAsDataURL(file); }" />
                                </label>
                            </div>
                        </div>

                        {{-- Título y Etiqueta --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Título de la Promoción</label>
                                <input type="text" name="title" x-model="promoData.title" required placeholder="Ej: Jueves de Alitas" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Etiqueta (Arriba derecha)</label>
                                <input type="text" name="tag" x-model="promoData.tag" placeholder="Ej: ¡Solo Jueves!" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                            </div>
                        </div>

                        {{-- Icono, Precio, Caducidad --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Icono (Si no hay img)</label>
                                <input type="text" name="icon" x-model="promoData.icon" placeholder="🍔" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-xl text-center focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Texto de Precio</label>
                                <input type="text" name="price_text" x-model="promoData.price_text" required placeholder="Ej: 2x1.5" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Caducidad</label>
                                <input type="date" name="end_date" x-model="promoData.end_date" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white">
                            </div>
                        </div>

                        {{-- Color y Descripción --}}
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Color de Fondo (Si no hay img)</label>
                            <select name="color_gradient" x-model="promoData.color_gradient" class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white appearance-none">
                                <option value="from-green-600 to-green-900">🟢 Verde (La 501)</option>
                                <option value="from-orange-500 to-red-700">🟠 Naranja / Rojo</option>
                                <option value="from-purple-600 to-indigo-900">🟣 Morado / Indigo</option>
                                <option value="from-blue-500 to-blue-800">🔵 Azul</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Descripción Completa</label>
                            <textarea name="description" x-model="promoData.description" rows="3" required class="w-full bg-zinc-100 dark:bg-white/5 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 transition text-zinc-900 dark:text-white resize-none"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" x-show="!isSubmitting" @click="openModal = false" class="flex-1 px-6 py-3 rounded-xl font-bold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 transition">Cancelar</button>
                        <button type="submit" :disabled="isSubmitting" :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition flex justify-center items-center gap-2">
                            <span x-text="isSubmitting ? 'Guardando...' : (isEdit ? 'Guardar Cambios' : 'Crear Promoción')"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function promoManager() {
        return {
            openModal: false,
            isEdit: false,
            isSubmitting: false,
            actionUrl: '',
            imagePreview: null,
            promoData: { title: '', description: '', tag: '', price_text: '', icon: '🔥', color_gradient: 'from-green-600 to-green-900', end_date: '' },

            openCreate() {
                this.isEdit = false;
                this.actionUrl = '{{ route("admin.promotions.store") }}';
                this.imagePreview = null;
                this.promoData = { title: '', description: '', tag: '', price_text: '', icon: '🔥', color_gradient: 'from-green-600 to-green-900', end_date: '' };
                this.isSubmitting = false;
                this.openModal = true;
            },

            openEdit(item) {
                this.isEdit = true;
                let baseUrl = '{{ route("admin.promotions.update", ":id") }}';
                this.actionUrl = baseUrl.replace(':id', item.id); 
                
                this.imagePreview = item.image ? `/storage/${item.image}` : null;
                this.promoData = {
                    title: item.title,
                    description: item.description,
                    tag: item.tag || '',
                    price_text: item.price_text,
                    icon: item.icon || '🔥',
                    color_gradient: item.color_gradient || 'from-green-600 to-green-900',
                    end_date: item.end_date || ''
                };
                this.isSubmitting = false;
                this.openModal = true;
            }
        }
    }
</script>
@endsection