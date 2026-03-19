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

    public function index()
    {
        $totalVentas  = Order::whereIn('status', ['delivered', 'entregado'])->sum('total');
        $totalPedidos = Order::whereIn('status', ['delivered', 'entregado'])->count();
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

        return view('admin.dashboard', compact('stats', 'primeraFecha', 'ultimaFecha', 'topProducts'));
    }

    public function exportSalesCSV(Request $request)
    {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate   = $request->end_date . ' 23:59:59';

        $summary = \App\Models\Order::selectRaw('payment_method, COUNT(*) as count, SUM(total) as sum')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['delivered', 'entregado'])
            ->groupBy('payment_method')
            ->get();

        $totalSum   = $summary->sum('sum');
        $totalCount = $summary->sum('count');

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

        $row += 3;

        $sheet->setCellValue('A' . $row, 'DESGLOSE DE MOVIMIENTOS');
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
            ->whereIn('status', ['delivered', 'entregado'])
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

        $fileName = 'Corte_Ventas_La501_' . date('d_m_Y') . '.xlsx';

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function apiStats()
    {
        $totalVentas = Order::whereIn('status', ['delivered', 'entregado'])->sum('total');
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
        $query  = Order::whereIn('status', ['delivered', 'entregado']);

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
}
