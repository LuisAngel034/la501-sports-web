<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{

    private const DATE_FORMAT_DMY  = 'd/m/Y';
    private const NUMBER_FORMAT_MX = '"$"#,##0.00_-';

    public function index(Request $request)
    {
        $totalVentas  = Order::where('status', 'paid')->sum('total');
        $totalPedidos = Order::where('status', 'paid')->count();
        $ticketPromedio = $totalPedidos > 0 ? ($totalVentas / $totalPedidos) : 0;
        $pedidosHoy   = Order::whereDate('created_at', Carbon::today())->count();
        $enProceso    = Order::where('status', 'pending')->count();

        $stats = [
            'total_ventas'    => $totalVentas,
            'pedidos_hoy'     => $pedidosHoy,
            'en_proceso'      => $enProceso,
            'ticket_promedio' => $ticketPromedio,
        ];

        $primeraVenta = Order::min('created_at');
        $primeraFecha = $primeraVenta ? Carbon::parse($primeraVenta)->format('Y-m-d') : date('Y-m-d');
        $ultimaFecha  = date('Y-m-d');

        try {
            $topProducts = DB::table('v_top_productos')
                ->select('producto as name', 'cantidad_vendida as total_vendido')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $topProducts = [];
        }

        $rotacionDate = $request->input('rotacion_date', date('Y-m'));
        try {
            $fechaRotacion = Carbon::createFromFormat('Y-m', $rotacionDate);
        } catch (\Exception $e) {
            $fechaRotacion = Carbon::today();
            $rotacionDate = $fechaRotacion->format('Y-m');
        }

        $inicioMes = $fechaRotacion->copy()->startOfMonth();
        
        if ($fechaRotacion->isCurrentMonth()) {
            $finMes = Carbon::today()->endOfDay();
            $diasEvaluados = max(1, Carbon::today()->day);
        } else {
            $finMes = $fechaRotacion->copy()->endOfMonth()->endOfDay();
            $diasEvaluados = $fechaRotacion->daysInMonth;
        }

        $rawTotalVendido = 'SUM(order_items.quantity) as total_vendido';

        // MEDIA ARITMETICA
        $mediaAritmetica = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.created_at', [$inicioMes, $finMes])
            ->select('products.name', DB::raw($rawTotalVendido))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get()
            ->map(function ($item) use ($diasEvaluados) {
                $item->media_diaria = round($item->total_vendido / $diasEvaluados, 2);
                return $item;
            });
        
        // CALCULO DE MODA MATEMATICA
        $modaMatematica = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.created_at', [$inicioMes, $finMes])
            ->select('products.name', DB::raw('COUNT(*) as frecuencia'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('frecuencia')
            ->limit(5)
            ->get();

        // MODELO PREDICTIVO
        $fechaInicioPred = $request->input('start_date', Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d'));
        $fechaFinPred = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $startCarbon = Carbon::parse($fechaInicioPred)->startOfDay();
        $endCarbon = Carbon::parse($fechaFinPred)->endOfDay();
        $diffDays = $startCarbon->diffInDays($endCarbon) + 1;

        $ordersQuery = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startCarbon, $endCarbon])
            ->orderBy('created_at', 'asc')
            ->get();

        $groupedTemp = collect();

        if ($diffDays <= 14) {
            $granularidad = 'Día';
            $labelFormato = 'd M Y';
            $groupedTemp = $ordersQuery->groupBy(fn($q) => Carbon::parse($q->created_at)->format('Y-m-d'));
            
        } elseif ($diffDays <= 60) {
            $granularidad = 'Semana';
            $labelFormato = 'd M';
            $semanasCompletas = floor($diffDays / 7);
            $diasCompletos = $semanasCompletas * 7;
            

            $fechaFinValida = $startCarbon->copy()->addDays($diasCompletos)->subSecond();
            
            $groupedTemp = $ordersQuery->where('created_at', '<=', $fechaFinValida)
                ->groupBy(function($q) use ($startCarbon) {
                    $daysDiff = $startCarbon->diffInDays(Carbon::parse($q->created_at));
                    $weekNum = floor($daysDiff / 7);
                    return $startCarbon->copy()->addDays($weekNum * 7)->format('Y-m-d');
                });
                
        } else {
            $granularidad = 'Mes';
            $labelFormato = 'M Y';
            $groupedOriginal = $ordersQuery->groupBy(fn($q) => Carbon::parse($q->created_at)->startOfMonth()->format('Y-m-d'));
            
            $ultimoMesKey = $groupedOriginal->keys()->last();
            if ($ultimoMesKey) {
                $finDeEseMes = Carbon::parse($ultimoMesKey)->endOfMonth()->endOfDay();
                if ($endCarbon->lt($finDeEseMes)) {
                    $groupedOriginal->pop();
                }
            }
            $groupedTemp = $groupedOriginal;
        }

        $historialSintetizado = collect();
        foreach ($groupedTemp as $key => $group) {
            $historialSintetizado->push((object)[
                'etiqueta' => Carbon::parse($key)->format($labelFormato),
                'total_ganado' => $group->sum('total')
            ]);
        }

        $n = $historialSintetizado->count();
        $gananciaProyectada = 0;
        $k_constante = 0;
        $p0 = 0;
        $p_last = 0;

        $fechasChart = [];
        $realesChart = [];
        $prediccionChart = [];

        if ($n > 1) {
            $p0 = $historialSintetizado->first()->total_ganado;
            $p_last = $historialSintetizado->last()->total_ganado;
            $t_last = $n - 1;

            if ($p0 > 0 && $p_last > 0) {
                $k_raw = log($p_last / $p0) / $t_last;
                $k_constante = round($k_raw, 4);

                $t_next = $n;
                $gananciaProyectada = $p0 * exp($k_constante * $t_next);

                foreach ($historialSintetizado as $index => $item) {
                    $fechasChart[] = $item->etiqueta;
                    $realesChart[] = round($item->total_ganado, 2);
                    $prediccionChart[] = round($p0 * exp($k_constante * $index), 2);
                }
                
                $articulo = ($granularidad == 'Semana') ? 'Próxima' : 'Próximo';
                
                $fechasChart[] = "Proyección (" . $articulo . " " . $granularidad . ")";
                $realesChart[] = null;
                $prediccionChart[] = round($gananciaProyectada, 2);

            } else {
                $gananciaProyectada = $p_last;
            }
        } else {
            $gananciaProyectada = $n > 0 ? $historialSintetizado->first()->total_ganado * 1.10 : 0;
        }

        $fechasChartJson = json_encode($fechasChart);
        $realesChartJson = json_encode($realesChart);
        $prediccionChartJson = json_encode($prediccionChart);

        return view('admin.dashboard', compact(
            'stats', 'primeraFecha', 'ultimaFecha', 'topProducts',
            'mediaAritmetica', 'modaMatematica', 'gananciaProyectada',
            'historialSintetizado', 'fechaInicioPred', 'fechaFinPred', 'k_constante', 'p0', 'p_last',
            'fechasChartJson', 'realesChartJson', 'prediccionChartJson', 'granularidad', 'rotacionDate'
        ));
    }

    public function exportSalesCSV(Request $request)
    {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate   = $request->end_date . ' 23:59:59';

        $summary = \App\Models\Order::selectRaw('payment_method, COUNT(*) as count, SUM(total) as sum')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'paid')
            ->groupBy('payment_method')
            ->get();

        $totalSum   = $summary->sum('sum');
        $totalCount = $summary->sum('count');

        $ventasPorCategoria = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'paid')
            ->whereNotNull('products.category')
            ->select('products.category', DB::raw('SUM(order_items.quantity) as total_vendido'), DB::raw('SUM(order_items.subtotal) as ingresos'))
            ->groupBy('products.category')
            ->orderByDesc('total_vendido')
            ->get();
        
        $totalArticulosVendidos = $ventasPorCategoria->sum('total_vendido');

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Corte de Caja');

        $styleTitle = [
            'font' => ['bold' => true, 'size' => 15, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF18181B']],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDD3A1D']],
        ];
        $styleTotal = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FF15803D']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDCFCE7']],
        ];

        $sheet->mergeCells('A1:E2');
        $sheet->setCellValue('A1', '📊 REPORTE DE VENTAS - LA 501 SPORTS BAR');
        $sheet->getStyle('A1:E2')->applyFromArray($styleTitle);

        $sheet->setCellValue('A4', 'Sucursal:');
        $sheet->setCellValue('B4', 'La 501');
        $sheet->setCellValue('A5', 'Fecha de Emisión:');
        $sheet->setCellValue('B5', date(self::DATE_FORMAT_DMY . ' h:i A'));
        $sheet->setCellValue('A6', 'Rango Reportado:');
        $sheet->setCellValue('B6',
            date(self::DATE_FORMAT_DMY, strtotime($startDate)) . ' al ' .
            date(self::DATE_FORMAT_DMY, strtotime($endDate))
        );
        $sheet->getStyle('A4:A6')->getFont()->setBold(true);

        // SECCIÓN 1: RESUMEN DE COBROS
        $sheet->setCellValue('A8', 'RESUMEN DE COBROS');
        $sheet->mergeCells('A8:E8');
        $sheet->getStyle('A8:E8')->applyFromArray($styleHeader);

        $sheet->setCellValue('A9', 'Método de Pago');
        $sheet->mergeCells('A9:B9');
        $sheet->setCellValue('C9', 'Cant. Operaciones');
        $sheet->setCellValue('D9', 'Monto Total');
        $sheet->mergeCells('D9:E9');
        $sheet->getStyle('A9:E9')->getFont()->setBold(true);

        $row = 10;
        foreach ($summary as $item) {
            $methodName = $item->payment_method ? mb_strtoupper($item->payment_method) : 'EFECTIVO';
            $sheet->setCellValue('A' . $row, $methodName);
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue('C' . $row, $item->count);
            $sheet->setCellValue('D' . $row, $item->sum);
            $sheet->mergeCells("D{$row}:E{$row}");
            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode(self::NUMBER_FORMAT_MX);
            $row++;
        }

        $sheet->setCellValue('A' . $row, 'TOTAL INGRESOS');
        $sheet->mergeCells("A{$row}:B{$row}");
        $sheet->setCellValue('C' . $row, $totalCount);
        $sheet->setCellValue('D' . $row, $totalSum);
        $sheet->mergeCells("D{$row}:E{$row}");
        $sheet->getStyle("A{$row}:E{$row}")->applyFromArray($styleTotal);
        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode(self::NUMBER_FORMAT_MX);

        // SECCIÓN 2: ROTACIÓN POR CATEGORÍAS
        $row += 3;
        $sheet->setCellValue('A' . $row, 'ANÁLISIS DE ROTACIÓN POR CATEGORÍA');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($styleHeader);
        $row++;

        $sheet->setCellValue('A' . $row, 'Categoría');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->setCellValue('C' . $row, 'Platillos Vendidos');
        $sheet->setCellValue('D' . $row, '% Participación');
        $sheet->setCellValue('E' . $row, 'Ingresos Generados');
        $sheet->getStyle("A{$row}:E{$row}")->getFont()->setBold(true);
        $row++;

        foreach ($ventasPorCategoria as $cat) {
            $sheet->setCellValue('A' . $row, $cat->category);
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue('C' . $row, $cat->total_vendido);
            
            // Aplicación de tu fórmula matemática para el reporte
            $porcentaje = $totalArticulosVendidos > 0 ? round(($cat->total_vendido / $totalArticulosVendidos) * 100, 2) : 0;
            $sheet->setCellValue('D' . $row, $porcentaje . '%');
            
            $sheet->setCellValue('E' . $row, $cat->ingresos);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(self::NUMBER_FORMAT_MX);
            $row++;
        }

        // --- SECCIÓN 3: DESGLOSE DE MOVIMIENTOS ---
        $row += 3;
        $sheet->setCellValue('A' . $row, 'DESGLOSE DETALLADO DE MOVIMIENTOS');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($styleHeader);
        $row++;

        $sheet->setCellValue('A' . $row, 'Folio');
        $sheet->setCellValue('B' . $row, 'Fecha');
        $sheet->setCellValue('C' . $row, 'Hora');
        $sheet->setCellValue('D' . $row, 'Método Pago');
        $sheet->setCellValue('E' . $row, 'Total');
        $sheet->getStyle("A{$row}:E{$row}")->getFont()->setBold(true);
        $row++;

        \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'paid')
            ->orderBy('created_at', 'asc')
            ->chunk(200, function ($ordersChunk) use ($sheet, &$row) {
                foreach ($ordersChunk as $order) {
                    $metodoPago = $order->payment_method ? ucfirst(strtolower($order->payment_method)) : 'Efectivo';
                    $sheet->setCellValue('A' . $row, '#' . str_pad($order->id, 4, '0', STR_PAD_LEFT));
                    $sheet->setCellValue('B' . $row, $order->created_at->format(self::DATE_FORMAT_DMY));
                    $sheet->setCellValue('C' . $row, $order->created_at->format('h:i A'));
                    $sheet->setCellValue('D' . $row, $metodoPago);
                    $sheet->setCellValue('E' . $row, $order->total);
                    $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(self::NUMBER_FORMAT_MX);
                    $row++;
                }
            });

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'Corte_Ventas_La501_' . date('d_m_Y_His') . '.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $rutaSegura = storage_path('app/' . $fileName);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($rutaSegura);

        return response()->download($rutaSegura, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function apiStats()
    {
        $totalVentas = Order::where('status', 'paid')->sum('total');
        $pedidosHoy  = Order::whereDate('created_at', Carbon::today())->count();
        $enProceso   = Order::where('status', 'pending')->count();

        return response()->json([
            'total_ventas' => (float) $totalVentas,
            'pedidos_hoy'  => (int) $pedidosHoy,
            'en_proceso'   => (int) $enProceso,
        ]);
    }

    public function apiSales(Request $request)
    {
        $period = $request->get('period', 'day');
        $query  = Order::where('status', 'paid');

        $result = match ($period) {
            'month' => $this->buildMonthlyData($query),
            'year'  => $this->buildYearlyData($query),
            default => $this->buildDailyData($query),
        };

        return response()->json($result);
    }

    private function buildDailyData($query): array
    {
        $start  = Carbon::now()->subDays(29)->startOfDay();
        $orders = clone $query->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn($d) => Carbon::parse($d->created_at)->format('d M'));

        $labels = [];
        $data   = [];

        for ($i = 29; $i >= 0; $i--) {
            $label    = Carbon::now()->subDays($i)->format('d M');
            $labels[] = $label;
            $data[]   = isset($orders[$label]) ? $orders[$label]->sum('total') : 0;
        }

        return compact('labels', 'data');
    }

    private function buildMonthlyData($query): array
    {
        $start  = Carbon::now()->startOfYear();
        $orders = clone $query->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn($d) => Carbon::parse($d->created_at)->format('M Y'));

        $labels       = [];
        $data         = [];
        $currentMonth = Carbon::now()->month;

        for ($i = 1; $i <= $currentMonth; $i++) {
            $label    = Carbon::create(null, $i, 1)->format('M Y');
            $labels[] = $label;
            $data[]   = isset($orders[$label]) ? $orders[$label]->sum('total') : 0;
        }

        return compact('labels', 'data');
    }

    private function buildYearlyData($query): array
    {
        $start  = Carbon::now()->subYears(4)->startOfYear();
        $orders = clone $query->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn($d) => Carbon::parse($d->created_at)->format('Y'));

        $labels = [];
        $data   = [];

        for ($i = 4; $i >= 0; $i--) {
            $label    = Carbon::now()->subYears($i)->format('Y');
            $labels[] = $label;
            $data[]   = isset($orders[$label]) ? $orders[$label]->sum('total') : 0;
        }

        return compact('labels', 'data');
    }

    public function apiCategoryRotation(Request $request)
    {
        $rotacionDate = $request->input('rotacion_date', date('Y-m'));
        try {
            $fechaRotacion = Carbon::createFromFormat('Y-m', $rotacionDate);
        } catch (\Exception $e) {
            $fechaRotacion = Carbon::today();
        }

        $inicioMes = $fechaRotacion->copy()->startOfMonth();
        $finMes = $fechaRotacion->isCurrentMonth() ? Carbon::today()->endOfDay() : $fechaRotacion->copy()->endOfMonth()->endOfDay();

        $query = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.created_at', [$inicioMes, $finMes]);

        // 3. Agrupamos por categoría y preparamos los datos
        $ventasPorCategoria = $query->select('products.category', DB::raw('SUM(order_items.quantity) as total_vendido'))
            ->groupBy('products.category')
            ->orderByDesc('total_vendido')
            ->get();

        $ventasTotales = $ventasPorCategoria->sum('total_vendido');

        $labels = [];
        $data = [];
        $backgrounds = [];

        $colores = [
            'Bebidas'      => 'rgba(37, 99, 235, 0.85)',
            'Snacks'       => 'rgba(124, 58, 237, 0.85)',
            'Hamburguesas' => 'rgba(234, 88, 12, 0.85)',
            'Tacos'        => 'rgba(22, 163, 74, 0.85)',
            'Jochos'       => 'rgba(220, 38, 38, 0.85)',
            'Burritos'     => 'rgba(234, 179, 8, 0.85)'
        ];

        foreach ($ventasPorCategoria as $item) {
            $labels[] = $item->category;
            $porcentaje = $ventasTotales > 0 ? round(($item->total_vendido / $ventasTotales) * 100, 2) : 0;
            $data[] = $porcentaje;
            $backgrounds[] = $colores[$item->category] ?? 'rgba('.rand(100,200).','.rand(100,200).','.rand(100,200).', 0.85)';
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'backgroundColors' => $backgrounds
        ]);
    }
}
