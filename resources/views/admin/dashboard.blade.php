@extends('layouts.admin')

@section('content')
<div x-data="dashboardManager()" x-init="initDashboard()" class="p-8 max-w-7xl mx-auto min-h-screen bg-white dark:bg-[#0a0a0a] transition-colors duration-300">
    
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-zinc-900 dark:text-white">Panel de Administrador</h1>
        <p class="text-zinc-500 text-sm mt-1">Gestión de La 501 en tiempo real</p>
    </div>

    {{-- 1. ESTADÍSTICAS SUPERIORES (AHORA USAN x-text PARA ACTUALIZARSE) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-zinc-50 dark:bg-[#1a1612] p-6 rounded-[25px] border border-zinc-200 dark:border-white/5 flex items-center gap-4 shadow-sm relative overflow-hidden group">
            <div x-show="isUpdating" x-transition.opacity.duration.500ms class="absolute inset-0 bg-green-500/5 z-0" style="display: none;"></div>
            <div class="p-3 bg-green-500/10 rounded-xl text-green-500 text-xl relative z-10">💵</div>
            <div class="relative z-10">
                <p class="text-zinc-500 text-[10px] uppercase font-bold tracking-widest">Ventas Totales</p>
                <p class="text-2xl font-black text-zinc-900 dark:text-white" x-text="'$' + stats.total_ventas"></p>
            </div>
        </div>

        <div class="bg-zinc-50 dark:bg-[#1a1612] p-6 rounded-[25px] border border-zinc-200 dark:border-white/5 flex items-center gap-4 shadow-sm relative overflow-hidden">
            <div x-show="isUpdating" x-transition.opacity.duration.500ms class="absolute inset-0 bg-red-500/5 z-0" style="display: none;"></div>
            <div class="p-3 bg-red-500/10 rounded-xl text-red-500 text-xl relative z-10">🛍️</div>
            <div class="relative z-10">
                <p class="text-zinc-500 text-[10px] uppercase font-bold tracking-widest">Pedidos Hoy</p>
                <p class="text-2xl font-black text-zinc-900 dark:text-white" x-text="stats.pedidos_hoy"></p>
            </div>
        </div>

        <div class="bg-zinc-50 dark:bg-[#1a1612] p-6 rounded-[25px] border border-zinc-200 dark:border-white/5 flex items-center gap-4 shadow-sm">
            <div class="p-3 bg-blue-500/10 rounded-xl text-blue-500 text-xl">📅</div>
            <div>
                <p class="text-zinc-500 text-[10px] uppercase font-bold tracking-widest">Reservaciones</p>
                <p class="text-2xl font-black text-zinc-900 dark:text-white">0</p>
            </div>
        </div>

        <div class="bg-zinc-50 dark:bg-[#1a1612] p-6 rounded-[25px] border border-zinc-200 dark:border-white/5 flex items-center gap-4 shadow-sm relative overflow-hidden">
            <div x-show="isUpdating" x-transition.opacity.duration.500ms class="absolute inset-0 bg-orange-500/5 z-0" style="display: none;"></div>
            <div class="p-3 bg-orange-500/10 rounded-xl text-orange-500 text-xl relative z-10">🕒</div>
            <div class="relative z-10">
                <p class="text-zinc-500 text-[10px] uppercase font-bold tracking-widest">En Proceso</p>
                <p class="text-2xl font-black text-zinc-900 dark:text-white" x-text="stats.en_proceso"></p>
            </div>
        </div>
    </div>

    {{-- 2. SECCIÓN DE GRÁFICA (AQUÍ LE PASAMOS LA FUNCIÓN DE ACTUALIZAR LA GRÁFICA AL DASHBOARD MANAGER) --}}
    <div class="bg-zinc-50 dark:bg-[#1a1612] border border-zinc-200 dark:border-white/5 rounded-[40px] p-8 shadow-sm mb-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
            <div class="flex items-center gap-2">
                <span class="text-green-500 text-xl">📊</span>
                <h2 class="text-zinc-900 dark:text-white font-bold">Reporte de Ventas</h2>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button @click="exportModalOpen = true" class="bg-[#10b981] hover:bg-[#059669] text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar .CSV
                </button>

                <select x-model="period" @change="changePeriod($event.target.value)" class="bg-white dark:bg-zinc-900 text-zinc-500 dark:text-zinc-400 text-xs border border-zinc-200 dark:border-white/10 rounded-xl px-4 py-2 outline-none cursor-pointer font-bold flex-1 sm:flex-none">
                    <option value="day">Por Día (Últimos 30)</option>
                    <option value="month">Por Mes (Este Año)</option>
                    <option value="year">Por Año</option>
                </select>
            </div>
        </div>

        <div class="relative h-80 w-full">
            <canvas id="salesChartCanvas"></canvas>
            <div x-show="isEmpty" class="absolute inset-0 flex flex-col items-center justify-center opacity-30" style="display: none;">
                <span class="text-5xl mb-4">📈</span>
                <p class="text-zinc-500 italic text-sm">Sin ventas registradas</p>
            </div>
        </div>
    </div>

    {{-- 3. VENTANA MODAL PARA EXPORTAR --}}
    <div x-show="exportModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="exportModalOpen = false" x-transition.scale class="bg-white dark:bg-[#1a1612] p-8 rounded-[32px] w-full max-w-md shadow-2xl border border-zinc-200 dark:border-white/10 relative mx-4">
            
            <button @click="exportModalOpen = false" class="absolute top-6 right-6 text-zinc-400 hover:text-red-500 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="text-2xl font-extrabold text-zinc-900 dark:text-white mb-2">Exportar Ventas</h3>
            <p class="text-zinc-500 text-sm mb-6">Selecciona el periodo que deseas descargar en Excel.</p>

            <form action="{{ route('admin.sales.export') }}" method="GET">
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Fecha de Inicio</label>
                        <input type="date" name="start_date" required value="{{ $primeraFecha ?? date('Y-m-d') }}" 
                               class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl p-3 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-zinc-500 mb-2">Fecha Final</label>
                        <input type="date" name="end_date" required value="{{ $ultimaFecha ?? date('Y-m-d') }}" 
                               class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-xl p-3 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 outline-none transition cursor-pointer">
                    </div>
                </div>

                <button type="submit" @click="exportModalOpen = false" class="w-full mt-8 bg-[#10b981] hover:bg-[#059669] text-white font-bold py-4 rounded-xl transition shadow-lg shadow-green-600/20 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Descargar Archivo
                </button>
            </form>
        </div>
    </div>

</div>
 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function dashboardManager() {
        return {
            exportModalOpen: false,
            period: 'day',
            chart: null,
            isEmpty: false,
            lastChartData: null,

            stats: {
                total_ventas: parseFloat('{{ str_replace(',', '', $stats['total_ventas'] ?? 0) }}'),
                pedidos_hoy: parseInt('{{ $stats['pedidos_hoy'] ?? 0 }}'),
                en_proceso: parseInt('{{ $stats['en_proceso'] ?? 0 }}')
            },
            
            isUpdating: false,

            initDashboard() {
                this.updateChartData();
                
                setInterval(() => {
                    this.fetchNewStats();
                    this.updateChartData(true); 
                }, 3000);
            },

            changePeriod(newPeriod) {
                this.period = newPeriod;
                
                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }
                
                this.lastChartData = null; 
                
                this.updateChartData(false);
            },

            formatearDinero(cantidad) {
                return Number(cantidad).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },

            async fetchNewStats() {
                try {
                    const response = await fetch("{{ route('admin.api.stats') }}");
                    if (response.ok) {
                        const newStats = await response.json();
                        
                        if(this.stats.total_ventas !== newStats.total_ventas || this.stats.en_proceso !== newStats.en_proceso) {
                            this.isUpdating = true;
                            setTimeout(() => { this.isUpdating = false; }, 800);
                        }

                        this.stats = newStats;
                    }
                } catch (e) {
                    console.error("Error obteniendo stats en vivo:", e);
                }
            },

            async updateChartData(isSilentUpdate = false) {
                try {
                    const timestamp = new Date().getTime();
                    const url = `{{ route('admin.api.sales') }}?period=${this.period}&t=${timestamp}`;

                    const response = await fetch(url, {
                        cache: 'no-store',
                        headers: {
                            'Pragma': 'no-cache',
                            'Cache-Control': 'no-cache',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const json = await response.json();
                    const jsonString = JSON.stringify(json);

                    if (isSilentUpdate && this.lastChartData === jsonString) {
                        return; 
                    }
                    
                    this.lastChartData = jsonString;
                    this.isEmpty = json.data.length === 0;

                    if (!this.chart) {
                        const ctx = document.getElementById('salesChartCanvas').getContext('2d');
                        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(34, 197, 94, 0.4)');
                        gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');
                        
                        this.chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: json.labels,
                                datasets: [{
                                    label: 'Ventas',
                                    data: json.data,
                                    borderColor: '#22c55e',
                                    backgroundColor: gradient,
                                    fill: true,
                                    tension: 0.4,
                                    borderWidth: 4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6 
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { 
                                    legend: { display: false },
                                    tooltip: {
                                        enabled: true,
                                        mode: 'index',
                                        intersect: false,
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.dataset.label || '';
                                                if (label) { label += ': '; }
                                                if (context.parsed.y !== null) {
                                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                interaction: {
                                    mode: 'nearest',
                                    axis: 'x',
                                    intersect: false
                                },
                                scales: {
                                    y: { 
                                        grid: { color: 'rgba(128,128,128,0.1)' },
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value;
                                            }
                                        }
                                    },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    } else {
                        if (this.chart.tooltip) {
                            this.chart.tooltip.setActiveElements([], {x: 0, y: 0});
                        }
                        this.chart.setActiveElements([]);

                        this.chart.data.labels = json.labels;
                        this.chart.data.datasets[0].data = json.data;
                        this.chart.update(isSilentUpdate ? 'none' : undefined);
                    }
                } catch (e) { 
                    console.error("Error obteniendo gráfica:", e); 
                }
            }
        }
    }
</script>
@endsection