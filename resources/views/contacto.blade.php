@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-16 px-6">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">Contacto</h1>
        <p class="text-zinc-500 text-lg">Envíanos tus comentarios o sugerencias</p>
    </div>

    <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800/50 p-8 rounded-[40px] shadow-2xl">
        <div class="flex items-center gap-3 text-green-500 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <h2 class="text-xl font-bold dark:text-white">Formulario de Contacto</h2>
        </div>

        <p class="text-zinc-400 text-sm mb-8">Nos encanta escuchar a nuestros clientes. Déjanos tu mensaje y te responderemos pronto.</p>

        <form action="#" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Nombre *</label>
                    <input type="text" placeholder="Tu nombre" required
                        class="w-full bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium dark:text-zinc-300">Correo Electrónico *</label>
                    <input type="email" placeholder="correo@ejemplo.com" required
                        class="w-full bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium dark:text-zinc-300">Asunto</label>
                <input type="text" placeholder="Motivo de tu mensaje"
                    class="w-full bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium dark:text-zinc-300">Mensaje *</label>
                <textarea rows="4" placeholder="Escribe tu mensaje aquí..." required
                    class="w-full bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition resize-none"></textarea>
            </div>

            <button type="submit" 
                class="w-full py-4 bg-green-600 hover:bg-green-500 text-black font-bold rounded-2xl transition-all transform active:scale-[0.98] flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
                Enviar Mensaje
            </button>
        </form>
    </div>
</div>
@endsection