<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WaiterController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $ordenesActivas = Order::whereIn('status', ['pending', 'preparing', 'ready'])
                               ->whereNotNull('table_number')
                               ->get();

        $mesas      = [];
        $totalMesas = 6;

        for ($i = 1; $i <= $totalMesas; $i++) {
            $ordenesMesa = $ordenesActivas->filter(function ($orden) use ($i) {
                return (int) $orden->table_number === $i;
            });

            $mesas[] = [
                'id'     => $i,
                'ocupada'=> $ordenesMesa->count() > 0,
                'total'  => $ordenesMesa->sum('total'),
            ];
        }

        return view('mesero.mesas', compact('mesas'));
    }

    public function tomarPedido($mesaId)
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $menu = Product::all()->groupBy('category');
        return view('mesero.tomar_pedido', compact('mesaId', 'menu'));
    }

    public function cobrar(Request $request, $mesaId)
    {
        if (!in_array(Auth::user()->role, ['empleado', 'mesero', 'admin']) && Auth::id() !== 2) {
            return abort(403);
        }

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $orders = Order::where('table_number', $mesaId)
                       ->whereIn('status', ['pending', 'preparing', 'ready'])
                       ->get();

        foreach ($orders as $order) {
            $order->status         = 'paid';
            $order->payment_method = $request->payment_method;
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
            'user_id'          => Auth::id(),
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
                'order_id'     => $order->id,
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'quantity'     => $item['cantidad'],
                'price'        => $item['price'],
                'subtotal'     => $item['price'] * $item['cantidad'],
            ]);
        }

        return redirect()->route('mesero.mesas')->with('success', '¡Orden enviada a cocina exitosamente!');
    }
}
