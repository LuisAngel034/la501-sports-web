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
        if (Auth::user()->role !== 'empleado' && Auth::id() !== 2) return abort(403);

        $mesasOcupadas = Order::whereIn('status', ['pending', 'ready'])
                              ->whereNotNull('table_number')
                              ->get()
                              ->groupBy('table_number');

        return view('mesero.mesas', compact('mesasOcupadas'));
    }

    public function tomarPedido($mesaId)
    {
        if (Auth::user()->role !== 'empleado' && Auth::id() !== 2) return abort(403);

        $menu = Product::all()->groupBy('category');
        return view('mesero.tomar_pedido', compact('mesaId', 'menu'));
    }

    public function cobrar($mesaId)
    {
        if (Auth::user()->role !== 'empleado' && Auth::id() !== 2) return abort(403);

        $orders = Order::where('table_number', $mesaId)
                       ->whereIn('status', ['pending', 'ready'])
                       ->get();

        foreach ($orders as $order) {
            $order->status = 'delivered';
            $order->payment_method = 'efectivo';
            $order->save();
        }

        return back()->with('success', "Mesa $mesaId cobrada y liberada.");
    }

    public function guardarPedido(Request $request, $mesaId)
    {
        if (Auth::user()->role !== 'empleado' && Auth::id() !== 2) return abort(403);

        $request->validate([
            'carrito' => 'required',
            'total' => 'required|numeric'
        ]);

        $carrito = json_decode($request->carrito, true);

        if (empty($carrito)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => 'Mesa ' . $mesaId,
            'customer_phone' => 'Local',
            'customer_address' => 'Consumo en sucursal',
            'table_number' => $mesaId,
            'total' => $request->total,
            'status' => 'pending',
            'payment_method' => 'pendiente',
        ]);

        foreach ($carrito as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'quantity' => $item['cantidad'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['cantidad'],
            ]);
        }

        return redirect()->route('mesero.mesas')->with('success', '¡Orden enviada a cocina exitosamente!');
    }
}