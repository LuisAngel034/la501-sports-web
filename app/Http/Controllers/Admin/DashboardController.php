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


    // ========================================================
    // 2. EXPORTAR EL EXCEL (COLUMNAS SEPARADAS SIN CLIENTE)
    // ======================================================== 
    public function exportSalesCSV(Request $request)
    {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->end_date . ' 23:59:59';

        $fileName = 'Resumen_Ventas_La501_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            // BOM para que Excel lea los acentos perfecto
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 

            // --- CÁLCULOS DEL RESUMEN (Agrupamos por método de pago) ---
            $summary = \App\Models\Order::selectRaw('payment_method, COUNT(*) as count, SUM(total) as sum')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['delivered', 'entregado'])
                ->groupBy('payment_method')
                ->get();

            $totalSum = $summary->sum('sum');
            $totalCount = $summary->sum('count');

            // OJO AQUÍ: Cambiamos la ',' por ';' al final para que Excel lo separe en columnas
            
            // --- 1. CABECERA DEL REPORTE ---
            fputcsv($file, ['Sucursal:', 'La 501 Sports'], ';');
            fputcsv($file, ['Fecha de Emision:', date('d/m/Y h:i A')], ';');
            fputcsv($file, ['Rango Reportado:', date('d/m/Y', strtotime($startDate)) . ' al ' . date('d/m/Y', strtotime($endDate))], ';');
            fputcsv($file, [], ';'); // Fila vacía para separar

            // --- 2. RESUMEN DE VENTAS ---
            fputcsv($file, ['RESUMEN DE VENTAS'], ';');
            fputcsv($file, ['Metodo de Pago', 'Cant. Operaciones', 'Monto Total'], ';');

            foreach ($summary as $row) {
                // Si viene vacío en la BD, lo marcamos como Efectivo
                $methodName = $row->payment_method ? mb_strtoupper($row->payment_method) : 'EFECTIVO';
                
                fputcsv($file, [
                    $methodName,
                    $row->count,
                    '$ ' . number_format($row->sum, 2, '.', ',')
                ], ';');
            }
            
            // Fila de Total General
            fputcsv($file, ['TOTAL GENERAL', $totalCount, '$ ' . number_format($totalSum, 2, '.', ',')], ';');
            fputcsv($file, [], ';'); 
            fputcsv($file, [], ';'); 

            // --- 3. DESGLOSE DETALLADO (Anexo sin nombre de cliente) ---
            fputcsv($file, ['DESGLOSE DE MOVIMIENTOS'], ';');
            // Eliminamos la columna "Cliente"
            fputcsv($file, ['Folio', 'Fecha', 'Hora', 'Metodo de Pago', 'Total'], ';');

            // Traemos las órdenes con chunk para que soporte miles de registros sin trabarse
            \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['delivered', 'entregado'])
                ->orderBy('created_at', 'asc')
                ->chunk(200, function ($ordersChunk) use ($file) {
                    foreach ($ordersChunk as $order) {
                        $metodoPago = $order->payment_method ? ucfirst(strtolower($order->payment_method)) : 'Efectivo';

                        // Eliminamos la variable del cliente del arreglo
                        fputcsv($file, [
                            '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT), 
                            $order->created_at->format('d/m/Y'), 
                            $order->created_at->format('h:i A'), 
                            $metodoPago,
                            '$ ' . number_format($order->total, 2, '.', '')
                        ], ';'); 
                    }
                });

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