<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class KitchenController extends Controller
{
    private function checkAccess()
    {
        return Auth::check() && Auth::user()->role === 'cocinero';
    }

    public function index()
    {
        if (!$this->checkAccess()) {
            return abort(403);
        }

        $orders = Order::with('items')
            ->where(function ($query) {
                $query->whereNotNull('table_number')
                      ->whereIn('status', ['pending', 'preparing']);
            })
            ->orWhere(function ($query) {
                $query->whereNull('table_number')
                      ->whereIn('status', ['paid', 'preparing']);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('cocina.index', compact('orders'));
    }

    public function markAsReady(Request $request, $id)
    {
        if (!$this->checkAccess()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $order = Order::findOrFail($id);
        $order->status = 'ready';
        $order->save();

        // Enviar correo de notificación si el cliente está registrado
        if ($order->user_id) {
            $user = \App\Models\User::find($order->user_id);
            if ($user && $user->email) {
                try {
                    Mail::send('emails.order_status', ['order' => $order, 'user' => $user], function ($message) use ($user) {
                        $message->to($user->email)->subject('¡Tu pedido está listo! 🍳 - La 501 Sports');
                    });
                } catch (\Exception $e) {
                    // Ignorar errores de envío de correo para no interrumpir el flujo
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('kitchen.index')->with('success', 'Pedido marcado como listo');
    }

    public function apiActiveOrders()
    {
        if (!$this->checkAccess()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $orders = Order::with('items')
            ->where(function ($query) {
                $query->whereNotNull('table_number')
                      ->whereIn('status', ['pending', 'preparing']);
            })
            ->orWhere(function ($query) {
                $query->whereNull('table_number')
                      ->whereIn('status', ['paid', 'preparing']);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($orders);
    }
}
