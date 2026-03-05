<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'repartidor' && Auth::id() !== 2) {
            return abort(403, 'No tienes permiso para ver las entregas.');
        }

        $orders = Order::with('items')->where('status', 'pending')->latest()->get();
        
        return view('repartidor.index', compact('orders'));
    }

    public function deliver($id)
    {
        if (Auth::user()->role !== 'repartidor' && Auth::id() !== 2) {
            return abort(403);
        }

        $order = Order::findOrFail($id);
        $order->status = 'delivered';
        $order->save();

        return back()->with('success', '¡Pedido entregado y cobrado!');
    }
}