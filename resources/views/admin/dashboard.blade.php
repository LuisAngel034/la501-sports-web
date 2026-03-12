@extends('layouts.admin')

@section('content')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* ── VARIABLES Y DISEÑO BASE ── */
    .ad { --accent: #2563EB; --accent2: #1D4ED8; --gn: #16A34A; --gn2: #22C55E; --bg: #F8F8F8; --bg-card: #FFFFFF; --bg-input: #F4F4F5; --txt: #18181B; --txt-sub: #71717A; --bdr: #E4E4E7; }
    .dark .ad { --bg: #0A0A0A; --bg-card: #111111; --bg-input: #1C1C1C; --txt: #FAFAFA; --txt-sub: #71717A; --bdr: rgba(255,255,255,0.08); }
    .ad { background: var(--bg); min-height: 100%; }
    .ad-header { margin-bottom: 24px; }
    .ad-header h1 { font-size: 20px; font-weight: 700; color: var(--txt); margin: 0 0 2px; }
    .ad-header p  { font-size: 13px; color: var(--txt-sub); margin: 0; }
    
    /* ── TARJETAS ESTADÍSTICAS ── */
    .ad-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
    .ad-stat { background: var(--bg-card); border: 1px solid var(--bdr); border-radius: 10px; padding: 16px 18px; position: relative; overflow: hidden; transition: box-shadow .2s; }
    .ad-stat:hover { box-shadow: 0 3px 16px rgba(0,0,0,.07); }
    .ad-stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .ad-stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .7px; color: var(--txt-sub); }
    .ad-stat-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ad-stat-icon svg { width: 14px; height: 14px; }
    .ad-stat-icon.green  { background: rgba(22,163,74,.1);  color: #16A34A; }
    .ad-stat-icon.orange { background: rgba(249,115,22,.1); color: #EA580C; }
    .ad-stat-icon.blue   { background: rgba(37,99,235,.1);  color: #2563EB; }
    .ad-stat-icon.yellow { background: rgba(234,179,8,.1);  color: #B45309; }
    .dark .ad-stat-icon.green  { color: #4ADE80; }
    .dark .ad-stat-icon.orange { color: #FB923C; }
    .dark .ad-stat-icon.blue   { color: #60A5FA; }
    .dark .ad-stat-icon.yellow { color: #FCD34D; }
    .ad-stat-value { font-size: 26px; font-weight: 800; color: var(--txt); line-height: 1; margin: 0; letter-spacing: -.5px; }
    
    /* Flash overlay */
    .ad-stat-flash { position: absolute; inset: 0; background: rgba(34,197,94,.05); opacity: 0; pointer-events: none; transition: opacity .5s; }
    .ad-stat.flashing .ad-stat-flash { opacity: 1; }

    /* ── GRÁFICA Y CONTROLES ── */
    .ad-chart-card { background: var(--bg-card); border: 1px solid var(--bdr); border-radius: 10px; overflow: hidden; }
    .ad-chart-head { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--bdr); gap: 12px; flex-wrap: wrap; }
    .ad-chart-title { display: flex; align-items: center; gap: 8px; }
    .ad-chart-title-icon { width: 28px; height: 28px; border-radius: 7px; background: rgba(37,99,235,.08); border: 1px solid rgba(37,99,235,.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ad-chart-title-icon svg { width: 14px; height: 14px; color: var(--accent); }
    .ad-chart-title h2 { font-size: 14px; font-weight: 700; color: var(--txt); margin: 0; }
    .ad-chart-controls { display: flex; align-items: center; gap: 8px; }
    
    .ad-period-group { display: flex; background: var(--bg-input); border: 1px solid var(--bdr); border-radius: 7px; padding: 3px; gap: 2px; }
    .ad-period-btn { padding: 5px 12px; border-radius: 5px; font-size: 11px; font-weight: 600; letter-spacing: .3px; border: none; background: transparent; color: var(--txt-sub); cursor: pointer; transition: background .15s, color .15s; white-space: nowrap; }
    .ad-period-btn.active, .ad-period-btn:hover { background: var(--bg-card); color: var(--txt); box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    .dark .ad-period-btn.active, .dark .ad-period-btn:hover { box-shadow: 0 1px 3px rgba(0,0,0,.3); }

    .ad-export-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 7px; background: var(--bg-input); border: 1px solid var(--bdr); font-size: 11px; font-weight: 600; color: var(--txt-sub); cursor: pointer; transition: background .15s, border-color .15s, color .15s; }
    .ad-export-btn:hover { border-color: var(--gn); color: var(--gn); }

    .ad-chart-body { padding: 20px 18px; position: relative; }
    .ad-chart-canvas { height: 280px; width: 100%; }

    /* ── MODAL SEGURO (VANILLA JS) ── */
    .mi-modal-seguro {
        display: none; 
        position: fixed !important;
        inset: 0 !important;
        z-index: 9999999 !important;
        background: rgba(0,0,0,0.6) !important;
        backdrop-filter: blur(4px) !important;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .ad-modal { background: var(--bg-card); border: 1px solid var(--bdr); border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); }
    .ad-modal-head { display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border-bottom: 1px solid var(--bdr); }
    .ad-modal-head h3 { font-size: 15px; font-weight: 700; color: var(--txt); margin: 0; }
    .ad-modal-head p  { font-size: 12px; color: var(--txt-sub); margin: 3px 0 0; }
    .ad-modal-close { width: 26px; height: 26px; border-radius: 6px; background: var(--bg-input); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--txt-sub); }
    .ad-modal-close:hover { background: var(--bdr); }
    .ad-modal-body { padding: 18px; display: flex; flex-direction: column; gap: 14px; }
    .ad-modal-foot { padding: 14px 18px; border-top: 1px solid var(--bdr); }
    .ad-label { display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--txt-sub); margin-bottom: 4px; }
    .ad-input { width: 100%; padding: 8px 10px; background: var(--bg-input); border: 1px solid var(--bdr); border-radius: 7px; font-size: 13px; color: var(--txt); outline: none; }
    .ad-btn-save { width: 100%; padding: 9px; border-radius: 7px; background: var(--gn); color: #fff; border: none; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; }

    @media (max-width: 900px) { .ad-stats { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 540px) { .ad-stats { grid-template-columns: 1fr 1fr; gap: 8px; } .ad-stat-value { font-size: 20px; } .ad-chart-head { flex-direction: column; align-items: flex-start; } }
</style>

<div class="ad" x-data="dashboardManager()" x-init="initDashboard()">

    <div class="ad-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <div>
            <h1>Panel de Ventas</h1>
            <p>Gestión de La 501 en tiempo real</p>
        </div>
    </div>

    <div class="ad-stats">
        <div class="ad-stat" :class="isUpdating ? 'flashing' : ''">
            <div class="ad-stat-flash"></div>
            <div class="ad-stat-top">
                <span class="ad-stat-label">Ventas Totales</span>
                <div class="ad-stat-icon green"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            </div>
            <p class="ad-stat-value" x-text="'$' + formatearDinero(stats.total_ventas)"></p>
        </div>

        <div class="ad-stat" :class="isUpdating ? 'flashing' : ''">
            <div class="ad-stat-flash"></div>
            <div class="ad-stat-top">
                <span class="ad-stat-label">Pedidos Hoy</span>
                <div class="ad-stat-icon orange"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
            </div>
            <p class="ad-stat-value" x-text="stats.pedidos_hoy"></p>
        </div>

        <div class="ad-stat">
            <div class="ad-stat-top"><span class="ad-stat-label">Reservaciones</span><div class="ad-stat-icon blue"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div></div>
            <p class="ad-stat-value">0</p>
        </div>

        <div class="ad-stat" :class="isUpdating ? 'flashing' : ''">
            <div class="ad-stat-flash"></div>
            <div class="ad-stat-top"><span class="ad-stat-label">En Proceso</span><div class="ad-stat-icon yellow"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div>
            <p class="ad-stat-value" x-text="stats.en_proceso"></p>
        </div>
    </div>

    <div class="ad-chart-card">
        <div class="ad-chart-head">
            <div class="ad-chart-title">
                <div class="ad-chart-title-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                <h2>Reporte de Ventas</h2>
            </div>

            <div class="ad-chart-controls">
                <div class="ad-period-group">
                    <button @click="changePeriod('day')" :class="period === 'day' ? 'active' : ''" class="ad-period-btn">30 Días</button>
                    <button @click="changePeriod('month')" :class="period === 'month' ? 'active' : ''" class="ad-period-btn">Meses</button>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="button" onclick="abrirVentanita('modal-export')" class="ad-export-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Exportar CSV
                    </button>
                </div>
            </div>
        </div>

        <div class="ad-chart-body">
            <div class="ad-chart-canvas"><canvas id="salesChartCanvas"></canvas></div>
        </div>
    </div>
</div> 


{{-- Modal de Exportar --}}
<div id="modal-export" class="mi-modal-seguro">
    <div class="ad-modal">
        <div class="ad-modal-head">
            <div>
                <h3>Exportar Ventas</h3>
                <p>Descarga un reporte en Excel (CSV)</p>
            </div>
            <button type="button" onclick="cerrarVentanita('modal-export')" class="ad-modal-close">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.sales.export.excel') }}" method="GET" onsubmit="setTimeout(() => cerrarVentanita('modal-export'), 500)">
            <div class="ad-modal-body">
                <div>
                    <label class="ad-label">Fecha de inicio</label>
                    <input type="date" name="start_date" required value="{{ $primeraFecha ?? date('Y-m-d') }}" class="ad-input">
                </div>
                <div>
                    <label class="ad-label">Fecha final</label>
                    <input type="date" name="end_date" required value="{{ $ultimaFecha ?? date('Y-m-d') }}" class="ad-input">
                </div>
            </div>
            <div class="ad-modal-foot">
                <button type="submit" class="ad-btn-save">Descargar Reporte</button>
            </div>
        </form>
    </div>
</div>


<script>
    function abrirVentanita(idModal) {
        document.getElementById(idModal).style.setProperty('display', 'flex', 'important');
    }
    function cerrarVentanita(idModal) {
        document.getElementById(idModal).style.setProperty('display', 'none', 'important');
    }

    let salesChartInstance = null;

    function dashboardManager() {
        return {
            period: 'day',
            isUpdating: false,
            stats: {
                total_ventas: parseFloat('{{ str_replace(',', '', $stats['total_ventas'] ?? 0) }}'),
                pedidos_hoy:  parseInt('{{ $stats['pedidos_hoy'] ?? 0 }}'),
                en_proceso:   parseInt('{{ $stats['en_proceso'] ?? 0 }}')
            },
            initDashboard() {
                this.updateChartData();
                const pusher = new Pusher('491d18da8b8b427e4969', { cluster: 'us2' });
                const channel = pusher.subscribe('dashboard-channel');
                channel.bind('dashboard.updated', () => {
                    this.fetchNewStats();
                    this.updateChartData(true);
                });
            },
            changePeriod(newPeriod) {
                this.period = newPeriod;
                this.updateChartData(false);
            },
            formatearDinero(cantidad) {
                return Number(cantidad).toLocaleString('en-US', { minimumFractionDigits: 2 });
            },
            async fetchNewStats() {
                try {
                    const res = await fetch("{{ route('admin.api.stats') }}");
                    if (res.ok) this.stats = await res.json();
                } catch(e) { console.error('Error stats:', e); }
            },
            async updateChartData(isSilentUpdate = false) {
                try {
                    const url = `{{ route('admin.api.sales') }}?period=${this.period}&t=${Date.now()}`;
                    const res = await fetch(url);
                    const json = await res.json();
                    const ctx = document.getElementById('salesChartCanvas').getContext('2d');

                    if (!salesChartInstance) {
                        salesChartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: json.labels,
                                datasets: [{ label: 'Ventas', data: json.data, borderColor: '#2563EB', tension: 0.4, fill: true, backgroundColor: 'rgba(37,99,235,0.1)' }]
                            },
                            options: { responsive: true, maintainAspectRatio: false }
                        });
                    } else {
                        salesChartInstance.data.labels = json.labels;
                        salesChartInstance.data.datasets[0].data = json.data;
                        salesChartInstance.update();
                    }
                } catch(e) { console.error('Error gráfica:', e); }
            }
        }
    }
</script>
@endsection