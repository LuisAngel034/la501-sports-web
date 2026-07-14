<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    private const ESTADOS_VENTA = ['paid', 'delivered'];

    public function today(): JsonResponse
    {
        $hoy = now()->toDateString();

        $pedidosHoy = Order::query()
            ->whereDate('created_at', $hoy);

        $ventasHoy = (clone $pedidosHoy)
            ->whereIn('status', self::ESTADOS_VENTA);

        $totalIngresos = (float) (clone $ventasHoy)->sum('total');
        $totalPedidosVendidos = (clone $ventasHoy)->count();

        $pedidosActivos = (clone $pedidosHoy)
            ->whereIn('status', ['pending', 'paid', 'preparing', 'ready'])
            ->count();

        $topPlatillos = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereDate('orders.created_at', $hoy)
            ->whereIn('orders.status', self::ESTADOS_VENTA)
            ->select('order_items.product_name')
            ->selectRaw('SUM(order_items.quantity) as unidades')
            ->selectRaw('SUM(order_items.subtotal) as ingresos')
            ->groupBy('order_items.product_name')
            ->orderByDesc('unidades')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $hoy,
                'total_revenue' => round($totalIngresos, 2),
                'total_orders' => $totalPedidosVendidos,
                'average_ticket' => $totalPedidosVendidos > 0
                    ? round($totalIngresos / $totalPedidosVendidos, 2)
                    : 0,
                'orders_in_kitchen' => $pedidosActivos,
                'top_products' => $topPlatillos->map(fn ($row) => [
                    'name' => $row->product_name,
                    'units' => (int) $row->unidades,
                    'revenue' => round((float) $row->ingresos, 2),
                ]),
            ],
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Historial diario de los últimos N días, usando la vista
     * `v_ventas_diarias` que ya existe en la base de datos.
     *
     * GET /v1/staff/dashboard/history?days=7
     */
    public function history(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'days' => ['nullable', 'integer', 'min:1', 'max:90'],
        ]);

        $dias = $validated['days'] ?? 7;
        $desde = now()->subDays($dias - 1)->toDateString();

        $historial = DB::table('v_ventas_diarias')
            ->where('fecha', '>=', $desde)
            ->orderByDesc('fecha')
            ->get()
            ->map(fn ($fila) => [
                'date' => (string) $fila->fecha,
                'total_orders' => (int) $fila->total_pedidos,
                'total_revenue' => round((float) $fila->ingresos_totales, 2),
            ]);

        return response()->json([
            'success' => true,
            'days' => $dias,
            'data' => $historial,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
