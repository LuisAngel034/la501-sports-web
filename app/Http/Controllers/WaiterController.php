<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WaiterController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $mesas = $this->getMesasData();
        return view('mesero.mesas', compact('mesas'));
    }

    public function apiGetMesas()
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return response()->json($this->getMesasData());
    }

    private const TOTAL_MESAS_BASE = 13;
    private const TOTAL_MESAS_MAX = 40;

    public function addTable()
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $total = min(self::TOTAL_MESAS_MAX, $this->totalMesasActual() + 1);
        Setting::updateOrCreate(['key' => 'total_mesas'], ['value' => (string) $total]);

        return response()->json(['success' => true, 'total_mesas' => $total]);
    }

    private function totalMesasActual(): int
    {
        return max(self::TOTAL_MESAS_BASE, (int) Setting::get('total_mesas', self::TOTAL_MESAS_BASE));
    }

    private function getMesasData()
    {
        $ordenesActivas = Order::whereIn('status', ['pending', 'preparing', 'ready'])
                               ->whereNotNull('table_number')
                               ->get();

        $mesas      = [];
        $totalMesas = $this->totalMesasActual();

        for ($i = 1; $i <= $totalMesas; $i++) {
            $ordenesMesa = $ordenesActivas->filter(function ($orden) use ($i) {
                return (int) $orden->table_number === $i;
            });

            $tienePendientes = $ordenesMesa->contains(function ($orden) {
                return in_array($orden->status, ['pending', 'preparing']);
            });

            $mesas[] = [
                'id'              => $i,
                'ocupada'         => $ordenesMesa->count() > 0,
                'total'           => (float) $ordenesMesa->sum('total'),
                'tiene_pendientes'=> $tienePendientes,
            ];
        }

        return $mesas;
    }

    public function tomarPedido($mesaId)
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $menu = Product::with('ingredientes')->get()->groupBy('category');
        return view('mesero.tomar_pedido', compact('mesaId', 'menu'));
    }

    public function cobrar(Request $request, $mesaId)
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $request->validate([
            'payment_method'   => 'required|string',
            'forced'           => 'nullable|boolean',
            'forced_reason'    => 'required_if:forced,1|nullable|string|max:255',
            'confirm_password' => 'required_if:forced,1|nullable|string',
        ]);

        $orders = Order::where('table_number', $mesaId)
                       ->whereIn('status', ['pending', 'preparing', 'ready'])
                       ->get();

        if ($orders->isEmpty()) {
            return back()->with('error', "La mesa $mesaId no tiene pedidos pendientes de cobro.");
        }

        // Si la cocina aún no terminó de preparar algún platillo, esta mesa está
        // "bloqueada" para cobro normal — solo se puede cobrar usando la vía forzada.
        $bloqueadaPorCocina = $orders->contains(fn ($order) => in_array($order->status, ['pending', 'preparing']));

        if ($bloqueadaPorCocina) {
            if (!$request->boolean('forced')) {
                return back()->with('error', "Hay platillos de la mesa $mesaId aún en preparación. Usa \"Forzar Cobro\" solo si la cocina no responde.");
            }

            if (!Hash::check((string) $request->confirm_password, Auth::user()->password)) {
                return back()->with('error', 'Contraseña incorrecta. No se pudo forzar el cobro.');
            }
        }

        foreach ($orders as $order) {
            $order->status                 = 'paid';
            $order->payment_method         = $request->payment_method;
            $order->charged_by             = Auth::id();
            $order->forced_checkout        = $bloqueadaPorCocina;
            $order->forced_checkout_reason = $bloqueadaPorCocina ? $request->forced_reason : null;
            $order->save();
        }

        return back()->with('success', "Mesa $mesaId cobrada exitosamente.");
    }

    public function guardarPedido(Request $request, $mesaId)
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $request->validate([
            'carrito' => 'required',
            'total'   => 'required|numeric',
        ]);

        $carrito = json_decode($request->carrito, true);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $order = Order::create([
            'user_id'          => null,
            'waiter_id'        => Auth::id(),
            'customer_name'    => 'Mesa ' . $mesaId,
            'customer_phone'   => 'Local',
            'customer_address' => 'Consumo en sucursal',
            'table_number'     => $mesaId,
            'total'            => $request->total,
            'status'           => 'pending',
            'payment_method'   => 'pendiente',
        ]);

        foreach ($carrito as $item) {
            \App\Models\OrderItem::create([
                'order_id'             => $order->id,
                'product_id'           => $item['id'],
                'product_name'         => $item['name'],
                'quantity'             => $item['cantidad'],
                'price'                => $item['price'],
                'subtotal'             => $item['price'] * $item['cantidad'],
                'excluded_ingredients' => $item['excluded_ingredients'] ?? [],
                'notes'                => !empty($item['notes']) ? mb_substr($item['notes'], 0, 100) : null,
            ]);
        }

        return redirect()->route('mesero.mesas')->with('success', '¡Orden enviada a cocina exitosamente!');
    }
}
