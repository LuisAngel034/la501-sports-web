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

    public function exportSalesCSV(Request $request)
    {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->end_date . ' 23:59:59';
        
        $summary = Order::selectRaw('payment_method, COUNT(*) as count, SUM(total) as sum')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['delivered', 'entregado'])
            ->groupBy('payment_method')
            ->get();
            
        $totalSum = $summary->sum('sum');
        $totalCount = $summary->sum('count');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Corte de Caja');

        // Estilos
        $styleTitle = ['font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0F172A']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]];
        
        $sheet->mergeCells('A1:E2');
        $sheet->setCellValue('A1', '📊 REPORTE DE VENTAS - LA 501');
        $sheet->getStyle('A1:E2')->applyFromArray($styleTitle);

        $sheet->setCellValue('A4', 'Rango:'); $sheet->setCellValue('B4', $startDate . ' al ' . $endDate);

        $row = 6;
        $sheet->setCellValue('A'.$row, 'Método de Pago'); $sheet->setCellValue('B'.$row, 'Operaciones'); $sheet->setCellValue('C'.$row, 'Total');
        $sheet->getStyle("A{$row}:C{$row}")->getFont()->setBold(true);
        $row++;

        foreach ($summary as $item) {
            $sheet->setCellValue('A'.$row, $item->payment_method ?: 'EFECTIVO');
            $sheet->setCellValue('B'.$row, $item->count);
            $sheet->setCellValue('C'.$row, $item->sum);
            $sheet->getStyle('C'.$row)->getNumberFormat()->setFormatCode('"$"#,##0.00');
            $row++;
        }

        foreach(range('A','C') as $col) { $sheet->getColumnDimension($col)->setAutoSize(true); }

        $fileName = 'Corte_La501_' . date('d_m_Y') . '.xlsx';
        if (ob_get_length()) { ob_end_clean(); }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $fileName .'"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

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

    public function apiSales(Request $request)
    {
        $period = $request->get('period', 'day');
        $query = Order::whereIn('status', ['delivered', 'entregado']);
        $labels = []; $data = [];

        if ($period == 'day') {
            $start = Carbon::now()->subDays(29)->startOfDay();
            $orders = clone $query->where('created_at', '>=', $start)->get()->groupBy(fn($d) => Carbon::parse($d->created_at)->format('d M'));
            for ($i = 29; $i >= 0; $i--) {
                $label = Carbon::now()->subDays($i)->format('d M');
                $labels[] = $label;
                $data[] = isset($orders[$label]) ? $orders[$label]->sum('total') : 0;
            }
        }
        return response()->json(['labels' => $labels, 'data' => $data]);
    }
}