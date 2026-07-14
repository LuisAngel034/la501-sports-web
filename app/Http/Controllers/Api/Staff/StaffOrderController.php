<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffOrderController extends Controller
{

    private const SIGUIENTE_ESTADO = [
        'pending' => 'ready',
        'paid' => 'ready',
        'preparing' => 'ready',
        'ready' => 'delivered',
    ];

    private const ESTADOS_ACTIVOS_COCINA = [
        'pending',
        'paid',
        'preparing',
        'ready',
    ];

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['nullable', 'string'],
        ]);

        $query = Order::query()
            ->with(['items:id,order_id,product_name,quantity,price,subtotal,excluded_ingredients'])
            ->orderBy('created_at', 'asc');

        if (!empty($validated['status'])) {
            $estados = array_filter(array_map('trim', explode(',', $validated['status'])));
            $query->whereIn('status', $estados);
        } else {
            $query->whereIn('status', self::ESTADOS_ACTIVOS_COCINA);
        }

        $orders = $query->get()->map(fn (Order $order) => $this->serializeOrder($order));

        return response()->json([
            'success' => true,
            'total' => $orders->count(),
            'data' => $orders,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load('items');

        return response()->json([
            'success' => true,
            'data' => $this->serializeOrder($order, true),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => [
                'nullable',
                'string',
                Rule::in(['pending', 'paid', 'preparing', 'ready', 'delivered', 'cancelled']),
            ],
        ]);

        $estadoAnterior = $order->status;

        if (!empty($validated['status'])) {
            $order->status = $validated['status'];
        } else {
            if (!isset(self::SIGUIENTE_ESTADO[$order->status])) {
                return response()->json([
                    'success' => false,
                    'error' => 'no_next_status',
                    'message' => "El pedido #{$order->id} ya está en estado '{$order->status}' y no tiene un siguiente paso automático.",
                ], 422, [], JSON_UNESCAPED_UNICODE);
            }

            $order->status = self::SIGUIENTE_ESTADO[$order->status];
        }

        $order->save();

        return response()->json([
            'success' => true,
            'message' => "Pedido #{$order->id} pasó de '{$estadoAnterior}' a '{$order->status}'.",
            'data' => $this->serializeOrder($order->fresh('items')),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function cancel(Order $order): JsonResponse
    {
        if (in_array($order->status, ['delivered', 'cancelled'], true)) {
            return response()->json([
                'success' => false,
                'error' => 'cannot_cancel',
                'message' => "El pedido #{$order->id} ya está '{$order->status}' y no se puede cancelar.",
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        $order->status = 'cancelled';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => "Pedido #{$order->id} cancelado.",
            'data' => $this->serializeOrder($order->fresh('items')),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function updateItemQuantity(
        Request $request,
        Order $order,
        OrderItem $item
    ): JsonResponse {
        if ((int) $item->order_id !== (int) $order->id) {
            return response()->json([
                'success' => false,
                'error' => 'item_not_in_order',
                'message' => 'Ese platillo no pertenece a este pedido.',
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        if ((int) $validated['quantity'] === 0) {
            $item->delete();
        } else {
            $item->quantity = $validated['quantity'];
            $item->subtotal = round($item->price * $item->quantity, 2);
            $item->save();
        }

        $order->total = $order->items()->sum('subtotal');
        $order->save();

        return response()->json([
            'success' => true,
            'message' => (int) $validated['quantity'] === 0
                ? 'Platillo eliminado del pedido.'
                : 'Cantidad actualizada.',
            'data' => $this->serializeOrder($order->fresh('items')),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    private function serializeOrder(Order $order, bool $detallado = false): array
    {
        return [
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'table_number' => $order->table_number,
            'address' => $order->customer_address,
            'status' => $order->status,
            'total' => (float) $order->total,
            'payment_method' => $order->payment_method,
            'created_at' => optional($order->created_at)->toISOString(),
            'minutes_waiting' => optional($order->created_at)->diffInMinutes(now()),
            'items' => $order->items->map(fn (OrderItem $item) => [
                'id' => $item->id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
                'subtotal' => (float) $item->subtotal,
                'excluded_ingredients' => $item->excluded_ingredients,
            ])->values(),
        ];
    }
}
