@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto py-16 px-6">
    <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 p-8 rounded-[40px] shadow-2xl">
        <h2 class="text-2xl font-bold dark:text-white mb-4">Recuperar Acceso</h2>
        <p class="text-zinc-500 text-sm mb-6">Ingresa tu correo y te enviaremos un enlace seguro.</p>
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="correo@ejemplo.com" required class="w-full p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 dark:text-white">
            <button class="w-full py-4 bg-green-600 text-black font-bold rounded-2xl hover:bg-green-500 transition">Enviar Enlace</button>
            <a href="{{ route('login') }}" class="block text-center text-sm text-zinc-500 pt-2">Volver al inicio</a>
        </form>
    </div>
</div>
@endsection