@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto py-12 px-6">
    <div class="bg-white dark:bg-[#1a1612] border border-zinc-200 dark:border-zinc-800 p-8 rounded-[40px] shadow-2xl">
        <h2 class="text-3xl font-bold dark:text-white text-center mb-8">Nueva Cuenta</h2>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500 text-red-500 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
            @csrf
            
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nombre completo" required class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">
            <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Teléfono" required class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">

            <select name="pregunta_secreta" required class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">
                <option value="" disabled selected>Pregunta de seguridad</option>
                <option>¿Cuál es el nombre de tu primera mascota?</option>
                <option>¿Cuál es tu platillo favorito de La 501?</option>
                <option>¿En qué ciudad se conocieron tus padres?</option>
            </select>

            <input type="text" name="respuesta_secreta" placeholder="Tu respuesta secreta" required class="p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">
            
            <div class="relative">
                <input id="password" type="password" name="password" placeholder="Contraseña" required 
                    class="w-full p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">
                <button type="button" onclick="togglePass('password', 'eye-1')" class="absolute right-4 top-4 text-zinc-500 hover:text-green-500 transition">
                    <span id="eye-1">👁️</span>
                </button>
            </div>

            <div class="px-2">
                <div class="h-1.5 w-full bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div id="strength-bar" class="h-full w-0 transition-all duration-300"></div>
                </div>
                <ul class="mt-3 grid grid-cols-1 gap-1 text-xs">
                    <li id="req-length" class="text-zinc-500 flex items-center gap-2">● Mínimo 8 caracteres </li>
                    <li id="req-upper" class="text-zinc-500 flex items-center gap-2">● Al menos una Mayúscula</li>
                    <li id="req-number" class="text-zinc-500 flex items-center gap-2">● Al menos un Número</li>
                    <li id="req-special" class="text-zinc-500 flex items-center gap-2">● Un carácter especial (!@#$)</li>
                </ul>
            </div>

            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required 
                    class="w-full p-4 rounded-2xl bg-zinc-100 dark:bg-zinc-900 dark:text-white border-none focus:ring-2 focus:ring-green-500">
                <button type="button" onclick="togglePass('password_confirmation', 'eye-2')" class="absolute right-4 top-4 text-zinc-500 hover:text-green-500 transition">
                    <span id="eye-2">👁️</span>
                </button>
            </div>

            <div class="flex items-start gap-3 px-2 mt-2">
                <input type="checkbox" name="terms" id="terms" required class="mt-1 w-5 h-5 rounded border-zinc-300 text-green-600 focus:ring-green-500 bg-zinc-100 dark:bg-zinc-900 dark:border-zinc-700">
                <label for="terms" class="text-sm text-zinc-600 dark:text-zinc-400">
                    Acepto los <a href="#" class="text-green-500 hover:underline">términos y condiciones</a> y la <a href="#" class="text-green-500 hover:underline">política de privacidad</a>.
                </label>
            </div>

            <button type="submit" class="w-full py-4 bg-green-600 text-black font-bold rounded-2xl hover:bg-green-500 transition-all shadow-lg shadow-green-500/20 mt-2">
                Crear Mi Cuenta
            </button>
        </form>
    </div>
</div>

<script>
    function togglePass(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        if (input.type === "password") {
            input.type = "text";
            eye.innerText = "🔒";
        } else {
            input.type = "password";
            eye.innerText = "👁️";
        }
    }

    const password = document.getElementById('password');
    const strengthBar = document.getElementById('strength-bar');
    
    password.addEventListener('input', function() {
        const val = password.value;
        const checks = {
            length: val.length >= 8,
            upper: /[A-Z]/.test(val),
            number: /[0-9]/.test(val),
            special: /[!@#$%^&*]/.test(val)
        };

        updateStatus('req-length', checks.length);
        updateStatus('req-upper', checks.upper);
        updateStatus('req-number', checks.number);
        updateStatus('req-special', checks.special);

        const score = Object.values(checks).filter(Boolean).length;
        const colors = ['bg-transparent', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
        strengthBar.className = `h-full transition-all duration-300 ${colors[score]}`;
        strengthBar.style.width = (score * 25) + '%';
    });

    function updateStatus(id, isValid) {
        const el = document.getElementById(id);
        if (isValid) {
            el.classList.remove('text-zinc-500');
            el.classList.add('text-green-500', 'font-medium');
            el.innerHTML = '✓ ' + el.innerHTML.split(' ').slice(1).join(' ');
        } else {
            el.classList.remove('text-green-500', 'font-medium');
            el.classList.add('text-zinc-500');
            el.innerHTML = '● ' + el.innerHTML.split(' ').slice(1).join(' ');
        }
    }
</script>
@endsection