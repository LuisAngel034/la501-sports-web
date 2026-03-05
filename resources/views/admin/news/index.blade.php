@extends('layouts.admin')

@section('content')
{{-- Envolvemos todo en el x-data "newsManager" --}}
<div class="p-8 max-w-7xl mx-auto" x-data="newsManager()">
    
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Gestionar Novedades</h1>
        {{-- Botón para Crear (Llama a openCreate) --}}
        <button @click="openCreate()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-600/20">
            + Nueva Publicación
        </button>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @foreach($news as $item)
        <div class="flex items-center justify-between p-4 bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-white/5 rounded-3xl group hover:border-blue-500/30 transition-all">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-zinc-100 dark:bg-black/20 overflow-hidden shrink-0">
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                </div>
                
                <div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-500 uppercase font-bold">
                        {{ $item->category }}
                    </span>
                    <h3 class="font-bold text-lg text-zinc-900 dark:text-white mt-1">{{ $item->title }}</h3>
                    <p class="text-sm text-zinc-500 line-clamp-1">{{ $item->content }}</p>
                </div>
            </div>

            <div class="flex gap-2">
                {{-- Botón para Editar (Pasa los datos del item usando JSON) --}}
                <button @click="openEdit({{ json_encode($item) }})" type="button" class="p-2 text-zinc-400 hover:text-blue-500 transition">✏️</button>
                
                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-zinc-400 hover:text-red-500 transition">🗑️</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Un solo archivo de modal al final --}}
    @include('admin.partials.modal-nueva-novedad')

</div>

{{-- Script de Alpine para manejar el estado del modal --}}
<script>
    function newsManager() {
        return {
            openModal: false,
            isEdit: false,
            isSubmitting: false,
            actionUrl: '',
            imagePreview: null,
            newsData: { title: '', category: 'Deportes', end_date: '', content: '' },

            openCreate() {
                this.isEdit = false;
                this.actionUrl = '{{ route("admin.news.store") }}';
                this.imagePreview = null;
                this.newsData = { title: '', category: 'Deportes', end_date: '', content: '' };
                this.isSubmitting = false;
                this.openModal = true;
            },

            openEdit(item) {
                this.isEdit = true;
                
                let baseUrl = '{{ route("admin.news.update", ":id") }}';
                
                this.actionUrl = baseUrl.replace(':id', item.id); 
                
                this.imagePreview = item.image ? `/storage/${item.image}` : null;
                this.newsData = {
                    title: item.title,
                    category: item.category,
                    end_date: item.end_date || '',
                    content: item.content
                };
                this.isSubmitting = false;
                this.openModal = true;
            }
        }
    }
</script>
@endsection