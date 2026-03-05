@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto py-16 px-6">
    <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 p-8 rounded-[40px] shadow-2xl">
        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white text-center mb-6">Bienvenido</h2>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="dark:text-zinc-400 text-sm">Correo</label>
                <input type="email" name="email" required class="w-full p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="dark:text-zinc-400 text-sm">Contraseña</label>
                <input type="password" name="password" required class="w-full p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button class="w-full py-4 bg-green-600 text-black font-bold rounded-2xl hover:bg-green-500 transition">Entrar</button>
            <div class="text-center space-y-2 pt-4">
                <a href="{{ route('password.request') }}" class="text-sm text-green-500 hover:underline">¿Olvidaste tu contraseña?</a><br>
                <a href="{{ route('register') }}" class="text-sm dark:text-zinc-500">¿No tienes cuenta? <span class="text-green-500">Regístrate</span></a>
            </div>
        </form>
    </div>
</div>
@endsection