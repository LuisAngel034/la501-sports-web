@extends('layouts.admin')

@section('content')
{{-- x-data controla los DOS modales (Crear y Cambiar Contraseña) --}}
<div class="p-8 max-w-7xl mx-auto min-h-screen bg-white dark:bg-[#0a0a0a]" 
     x-data="{ 
        showModal: false, 
        showPassModal: false,
        passUserId: '',
        passUserName: '',
        password: '',
        newPassword: '',
        
        generatePassword(target) {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%*';
            let pass = '';
            for (let i = 0; i < 10; i++) {
                pass += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            if(target === 'new') this.password = pass;
            if(target === 'edit') this.newPassword = pass;
        },
        
        openPasswordModal(id, name) {
            this.passUserId = id;
            this.passUserName = name;
            this.newPassword = '';
            this.showPassModal = true;
        }
     }">
    
    {{-- ENCABEZADO --}}
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Personal y Permisos</h1>
            <p class="text-zinc-500 text-sm mt-1">Gestiona los accesos de tu equipo de trabajo.</p>
        </div>
        <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition flex items-center gap-2 shadow-lg shadow-blue-500/20">
            <span>+</span> Nuevo Empleado
        </button>
    </div>

    {{-- TABLA DE EMPLEADOS --}}
    <div class="bg-zinc-50 dark:bg-[#1a1612] border border-zinc-200 dark:border-white/5 rounded-[40px] p-8 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-zinc-400 text-[10px] uppercase font-black tracking-tighter border-b border-zinc-200 dark:border-white/5">
                        <th class="pb-4 px-4">Nombre y Teléfono</th>
                        <th class="pb-4 px-4">Rol / Puesto</th>
                        <th class="pb-4 px-4 text-center">Estado</th>
                        <th class="pb-4 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-white/5">
                    @foreach($users->where('role', '!=', 'cliente') as $user)
                        <tr class="group hover:bg-white dark:hover:bg-white/5 transition-colors {{ $user->is_active ? '' : 'opacity-50' }}">
                            <td class="py-4 px-4">
                                <p class="font-bold text-zinc-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-zinc-500">{{ $user->telefono ?? 'Sin teléfono' }} • {{ $user->email }}</p>
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-purple-500/10 text-purple-500',
                                        'cajero' => 'bg-green-500/10 text-green-500',
                                        'cocinero' => 'bg-orange-500/10 text-orange-500',
                                        'repartidor' => 'bg-blue-500/10 text-blue-500',
                                        'limpieza' => 'bg-teal-500/10 text-teal-500',
                                        'empleado' => 'bg-zinc-500/10 text-zinc-500',
                                    ];
                                    $color = $roleColors[$user->role] ?? 'bg-zinc-100 text-zinc-400';
                                @endphp
                                <span class="{{ $color }} text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($user->is_active)
                                    <span class="text-green-500 text-xs font-bold">🟢 Activo</span>
                                @else
                                    <span class="text-orange-500 text-xs font-bold">⏸️ Suspendido</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                {{-- AHORA SÍ, PROTEGEMOS AL ID 2 --}}
                                @if($user->id !== 2) 
                                    <div class="flex justify-end gap-4 items-center">
                                        {{-- NUEVO BOTÓN: Cambiar Contraseña --}}
                                        <button type="button" @click="openPasswordModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="text-blue-500 hover:text-blue-600 text-xs font-bold flex items-center gap-1">
                                            🔑 Clave
                                        </button>

                                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="text-orange-500 hover:text-orange-600 text-xs font-bold">
                                                {{ $user->is_active ? 'Pausar' : 'Reactivar' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar a este empleado permanentemente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-bold">Despedir</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-[9px] text-blue-500 font-bold uppercase tracking-widest">Dueño del Sistema</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL 1: AGREGAR EMPLEADO --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-transition>
        <div @click.away="showModal = false" class="bg-white dark:bg-[#1a1612] w-full max-w-md rounded-[32px] p-8 border border-zinc-200 dark:border-white/10 shadow-2xl">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Agregar Personal</h2>
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-zinc-500 uppercase tracking-wide mb-1">Nombre Completo</label>
                        <input type="text" name="name" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase tracking-wide mb-1">Correo</label>
                            <input type="email" name="email" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase tracking-wide mb-1">Teléfono</label>
                            <input type="text" name="telefono" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Opcional">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase tracking-wide mb-1">Contraseña</label>
                            <div class="relative flex items-center">
                                <input type="text" name="password" x-model="password" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl pl-4 pr-10 py-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                <button type="button" @click="generatePassword('new')" class="absolute right-3 text-xl hover:scale-110 transition cursor-pointer" title="Generar Contraseña">🎲</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-zinc-500 uppercase tracking-wide mb-1">Puesto (Rol)</label>
                            <select name="role" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="admin">Administrador</option>
                                <option value="cajero">Cajer@</option>
                                <option value="cocinero">Cociner@</option>
                                <option value="repartidor">Repartidor</option>
                                <option value="limpieza">Limpieza</option>
                                <option value="empleado">Meser@</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" @click="showModal = false" class="flex-1 px-4 py-3 rounded-xl font-bold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 transition">Cancelar</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition shadow-lg shadow-blue-500/20">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 2: CAMBIAR CONTRASEÑA DE EMPLEADO --}}
    <div x-show="showPassModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-transition>
        <div @click.away="showPassModal = false" class="bg-white dark:bg-[#1a1612] w-full max-w-sm rounded-[32px] p-8 border border-zinc-200 dark:border-white/10 shadow-2xl">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Actualizar Clave</h2>
            <p class="text-xs text-zinc-500 mb-6">Nueva contraseña para: <span class="font-bold text-blue-500" x-text="passUserName"></span></p>
            
            {{-- Formulario dinámico. Ojo a la ruta: /usuarios/ + ID --}}
            <form x-bind:action="'/usuarios/' + passUserId" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-xs font-bold text-zinc-500 uppercase tracking-wide mb-1">Nueva Contraseña</label>
                    <div class="relative flex items-center">
                        <input type="text" name="password" x-model="newPassword" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl pl-4 pr-10 py-3 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <button type="button" @click="generatePassword('edit')" class="absolute right-3 text-xl hover:scale-110 transition cursor-pointer" title="Generar Contraseña">🎲</button>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" @click="showPassModal = false" class="flex-1 px-4 py-3 rounded-xl font-bold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 transition">Cancelar</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition shadow-lg shadow-blue-500/20">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection