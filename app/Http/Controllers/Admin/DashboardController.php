<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ====================================
    // 1. FUNCIÓN PRINCIPAL DEL DASHBOARD 
    // ====================================
    public function index()
    {
        $totalVentas = Order::whereIn('status', ['delivered', 'entregado'])->sum('total');
        $totalPedidos = Order::whereIn('status', ['delivered', 'entregado'])->count();
        
        $ticketPromedio = $totalPedidos > 0 ? ($totalVentas / $totalPedidos) : 0;

        $pedidosHoy = Order::whereDate('created_at', Carbon::today())->count();
        $enProceso = Order::where('status', 'pending')->count(); 

        $stats = [
            'total_ventas' => $totalVentas,
            'pedidos_hoy' => $pedidosHoy,
            'en_proceso' => $enProceso,
            'ticket_promedio' => $ticketPromedio,
        ];

        $primeraVenta = Order::min('created_at');
        $primeraFecha = $primeraVenta ? Carbon::parse($primeraVenta)->format('Y-m-d') : date('Y-m-d');
        $ultimaFecha = date('Y-m-d');

        try {
            $topProducts = DB::table('v_top_productos')
                ->select('producto as name', 'cantidad_vendida as total_vendido')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $topProducts = []; 
        }

        return view('admin.dashboard', compact('stats', 'primeraFecha', 'ultimaFecha', 'topProducts'));
    }


    // ===================================
    // 2. FUNCIÓN PARA EXPORTAR EL EXCEL
    // =================================== 
    public function exportSalesCSV(Request $request)
    {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->end_date . ' 23:59:59';

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
               ->whereIn('status', ['delivered', 'entregado'])
               ->orderBy('created_at', 'asc')
               ->get();

        $fileName = 'Reporte_Ventas_La501_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 

            fputcsv($file, ['Folio', 'Cliente', 'Fecha', 'Hora', 'Método de Pago', 'Total'], ',');

            foreach ($orders as $order) {
                $nombreCliente = $order->customer_name ? ucwords(strtolower($order->customer_name)) : 'Mostrador';
                $metodoPago = $order->payment_method ? ucfirst(strtolower($order->payment_method)) : 'No registrado';

                fputcsv($file, [
                    '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT), 
                    $nombreCliente,
                    $order->created_at->format('d/m/Y'), 
                    $order->created_at->format('h:i A'), 
                    $metodoPago,
                    number_format($order->total, 2, '.', '')
                ], ','); 
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ====================================
    // 3. API PARA ACTUALIZAR ESTADÍSTICAS
    // ====================================
    public function apiStats()
    {
        $totalVentas = Order::whereIn('status', ['delivered', 'entregado'])->sum('total');
        $pedidosHoy = Order::whereDate('created_at', Carbon::today())->count();
        
        $enProceso = Order::where('status', 'pending')->count(); 

        return response()->json([
            'total_ventas' => (float) $totalVentas, 
            'pedidos_hoy' => (int) $pedidosHoy,
            'en_proceso' => (int) $enProceso,
        ]);
    }

    // =========================================================================
    // 4. API PARA LA GRÁFICA DE VENTAS (Solo pedidos delivered/entregados)
    // =========================================================================
    public function apiSales(Request $request)
    {
        $period = $request->get('period', 'day');
        
        $query = Order::whereIn('status', ['delivered', 'entregado']);

        $labels = [];
        $data = [];

        if ($period == 'day') {
            // Agrupar por día (Últimos 30 días)
            $start = Carbon::now()->subDays(29)->startOfDay();
            $orders = clone $query->where('created_at', '>=', $start)
                                  ->get()
                                  ->groupBy(function($date) {
                                      return Carbon::parse($date->created_at)->format('d M');
                                  });
            for ($i = 29; $i >= 0; $i--) {
                $dateLabel = Carbon::now()->subDays($i)->format('d M');
                $labels[] = $dateLabel;
                $data[] = isset($orders[$dateLabel]) ? $orders[$dateLabel]->sum('total') : 0;
            }
        } elseif ($period == 'month') {
            // Agrupar por mes (Este año)
            $start = Carbon::now()->startOfYear();
            $orders = clone $query->where('created_at', '>=', $start)
                                  ->get()
                                  ->groupBy(function($date) {
                                      return Carbon::parse($date->created_at)->format('M Y');
                                  });

            $currentMonth = Carbon::now()->month;
            for ($i = 1; $i <= $currentMonth; $i++) {
                $dateLabel = Carbon::create(null, $i, 1)->format('M Y');
                $labels[] = $dateLabel;
                $data[] = isset($orders[$dateLabel]) ? $orders[$dateLabel]->sum('total') : 0;
            }
        } elseif ($period == 'year') {
            // Agrupar por año (Últimos 5 años)
            $start = Carbon::now()->subYears(4)->startOfYear();
            $orders = clone $query->where('created_at', '>=', $start)
                                  ->get()
                                  ->groupBy(function($date) {
                                      return Carbon::parse($date->created_at)->format('Y');
                                  });

            for ($i = 4; $i >= 0; $i--) {
                $dateLabel = Carbon::now()->subYears($i)->format('Y');
                $labels[] = $dateLabel;
                $data[] = isset($orders[$dateLabel]) ? $orders[$dateLabel]->sum('total') : 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}