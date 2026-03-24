@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto relative">

    <div class="mb-10 mt-8 md:mt-0">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Gestión de Reservaciones</h1>
        <p class="text-zinc-500 mt-2">Administra las mesas y eventos de tus clientes.</p>
    </div>

    {{-- MOCKUP DE LA TABLA (Bloqueado visualmente) --}}
    <div class="">
        
        {{-- Bloqueador invisible --}}
        <div class="absolute inset-0 z-10" title="Módulo en desarrollo"></div>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Próximas Reservas (Ejemplo visual)</h2>
            <button disabled class="bg-zinc-200 dark:bg-zinc-800 text-zinc-500 px-4 py-2 rounded-xl font-bold text-sm">Exportar PDF</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-sm text-zinc-400">
                        <th class="py-4 font-medium">Cliente</th>
                        <th class="py-4 font-medium">Fecha y Hora</th>
                        <th class="py-4 font-medium">Personas</th>
                        <th class="py-4 font-medium">Contacto</th>
                        <th class="py-4 font-medium text-right">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    {{-- Fila de ejemplo 1 --}}
                    <tr class="border-b border-zinc-100 dark:border-zinc-800/50">
                        <td class="py-4 font-bold text-zinc-700 dark:text-zinc-300">Juan Pérez</td>
                        <td class="py-4 text-zinc-500">15 de Enero, 4:00 PM</td>
                        <td class="py-4 text-zinc-500">4 Personas</td>
                        <td class="py-4 text-zinc-500">555-012-3456</td>
                        <td class="py-4 text-right">
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Confirmada</span>
                        </td>
                    </tr>
                    {{-- Fila de ejemplo 2 --}}
                    <tr class="border-b border-zinc-100 dark:border-zinc-800/50">
                        <td class="py-4 font-bold text-zinc-700 dark:text-zinc-300">María Gómez</td>
                        <td class="py-4 text-zinc-500">15 de Enero, 6:00 PM</td>
                        <td class="py-4 text-zinc-500">2 Personas</td>
                        <td class="py-4 text-zinc-500">555-987-6543</td>
                        <td class="py-4 text-right">
                            <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold">Pendiente</span>
                        </td>
                    </tr>
                    {{-- Fila de ejemplo 3 --}}
                    <tr>
                        <td class="py-4 font-bold text-zinc-700 dark:text-zinc-300">Familia Hernández</td>
                        <td class="py-4 text-zinc-500">16 de Enero, 2:00 PM</td>
                        <td class="py-4 text-zinc-500">8 Personas</td>
                        <td class="py-4 text-zinc-500">555-456-7890</td>
                        <td class="py-4 text-right">
                            <span class="bg-zinc-100 text-zinc-500 px-3 py-1 rounded-full text-xs font-bold">Cancelada</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
