@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto relative">

    <div class="mb-10 mt-8 md:mt-0">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Gestión de Reservaciones</h1>
        <p class="text-zinc-500 mt-2">Administra las mesas y eventos de tus clientes en tiempo real.</p>
    </div>

    {{-- Pestañas de Navegación: Corregidas a español --}}
    <div class="flex gap-4 mb-6 border-b border-zinc-200 dark:border-zinc-800">
        <a href="{{ route('admin.reservations.index', ['status' => 'pendiente']) }}"
           class="pb-2 px-4 text-sm font-bold transition-all {{ request('status', 'pendiente') == 'pendiente' ? 'border-b-2 border-green-600 text-green-600' : 'text-zinc-500 hover:text-zinc-700' }}">
            Pendientes
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'confirmada']) }}"
           class="pb-2 px-4 text-sm font-bold transition-all {{ request('status') == 'confirmada' ? 'border-b-2 border-green-600 text-green-600' : 'text-zinc-500 hover:text-zinc-700' }}">
            Aprobados
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'cancelada']) }}"
           class="pb-2 px-4 text-sm font-bold transition-all {{ request('status') == 'cancelada' ? 'border-b-2 border-green-600 text-green-600' : 'text-zinc-500 hover:text-zinc-700' }}">
            Cancelados
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 p-6 rounded-[32px] shadow-sm">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white capitalize">
                Reservas {{ request('status', 'pendiente') }}
            </h2>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-bold text-sm transition-colors">
                Exportar PDF
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-sm text-zinc-400">
                        <th class="py-4 font-medium">Cliente</th>
                        <th class="py-4 font-medium">Fecha y Hora</th>
                        <th class="py-4 font-medium text-center">Personas</th>
                        <th class="py-4 font-medium text-center">Zona</th>
                        <th class="py-4 font-medium">Contacto</th>
                        <th class="py-4 font-medium">Estado</th>
                        <th class="py-4 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($reservations as $res)
                        @php
                            $currentStatus = strtolower($res->status);
                            $classes = [
                                'pendiente'  => 'bg-yellow-100 text-yellow-700',
                                'confirmada' => 'bg-green-100 text-green-700',
                                'cancelada'  => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <tr class="border-b border-zinc-100 dark:border-zinc-800/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="py-4">
                                <p class="font-bold text-zinc-700 dark:text-zinc-300">{{ $res->nombre_completo }}</p>
                                <p class="text-xs text-zinc-500">{{ $res->correo_electronico }}</p>
                            </td>
                            <td class="py-4 text-zinc-500">
                                {{ \Carbon\Carbon::parse($res->fecha_reservacion)->format('d M, Y') }}<br>
                                <span class="text-xs font-semibold">{{ \Carbon\Carbon::parse($res->hora_reservacion)->format('h:i A') }}</span>
                            </td>
                            <td class="py-4 text-center text-zinc-500">
                                <span class="px-2 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg">{{ $res->cantidad_personas }}</span>
                            </td>
                            <td class="py-4 text-center text-zinc-500 capitalize">{{ $res->zona }}</td>
                            <td class="py-4 text-zinc-500">{{ $res->telefono }}</td>
                            <td class="py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $classes[$currentStatus] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $currentStatus }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    {{-- WhatsApp --}}
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $res->telefono) }}" target="_blank" class="p-2 bg-emerald-500/10 text-emerald-600 rounded-lg hover:bg-emerald-500 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    </a>

                                    {{-- Botón Confirmar: Enviando 'confirmada' --}}
                                    @if($currentStatus == 'pendiente')
                                        <form action="{{ route('admin.reservations.update-status', ['reservation' => $res->id, 'status' => 'confirmada']) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Aprobar Reserva" class="p-2 bg-green-500/10 text-green-600 rounded-lg hover:bg-green-500 hover:text-white transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Botón Cancelar: Enviando 'cancelada' --}}
                                    @if($currentStatus != 'cancelada')
                                        <form action="{{ route('admin.reservations.update-status', ['reservation' => $res->id, 'status' => 'cancelada']) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Cancelar Reserva" class="p-2 bg-red-500/10 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-zinc-500">No hay reservaciones {{ request('status', 'pendientes') }} aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
