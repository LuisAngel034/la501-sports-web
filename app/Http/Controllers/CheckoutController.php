<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('pedido')->with('error', 'Tu carrito está vacío.');
        }

        // BARRERA DE SEGURIDAD 2: Justo antes de mostrar la pantalla de cobro
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product || $product->available == 0) {
                // Si algo se agotó en el último segundo, lo mandamos de regreso al carrito para que el CartController limpie la sesión
                return redirect()->route('cart.index')->with('error', '¡Ups! Un platillo que ibas a pedir se acaba de agotar. Por favor revisa tu pedido.');
            }
        }

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('checkout', compact('total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:efectivo,tarjeta',
        ]);

        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('pedido');
        }

        // BARRERA DE SEGURIDAD 3: Justo en el milisegundo antes de procesar el pago o generar la orden
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product || $product->available == 0) {
                return redirect()->route('cart.index')->with('error', 'La compra no pudo completarse porque un platillo ya no está disponible en inventario.');
            }
        }

        $total = 0;
        $items_mercadopago = []; 

        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
            
            $items_mercadopago[] = [
                'title' => $details['name'],
                'quantity' => (int) $details['quantity'],
                'unit_price' => (float) $details['price'],
                'currency_id' => 'MXN',
            ];
        }

        // 1. Guardar la Orden Principal (Siempre inicia como pending)
        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total' => $total,
            'status' => 'pending', 
            'payment_method' => $request->payment_method,
        ]);

        // 2. Guardar los Platillos
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'subtotal' => $details['price'] * $details['quantity'],
            ]);
        }

        // 3. Lógica si es EFECTIVO
        if ($request->payment_method === 'efectivo') {
            session()->forget('cart');
            if (Auth::check()) {
                $user = Auth::user();
                $user->points += floor($total / 10);
                $user->save();
            }
            return redirect()->route('pedido')->with('success', '¡Pedido recibido! Lo prepararemos enseguida y pagarás al recibir.');
        } 
        
        // 4. Lógica si es TARJETA (Mercado Pago)
        if ($request->payment_method === 'tarjeta') {
            
            $response = Http::withToken(env('MERCADOPAGO_ACCESS_TOKEN'))->post('https://api.mercadopago.com/checkout/preferences', [
                'items' => $items_mercadopago,
                'external_reference' => $order->id, 
                'back_urls' => [
                    'success' => route('payment.success'),
                    'failure' => route('payment.failure'),
                    'pending' => route('payment.failure'),
                ],
                'auto_return' => 'approved',
            ]);

            if ($response->successful()) {
                $datos = $response->json();
                
                if (!isset($datos['init_point'])) {
                    dd('Mercado Pago no mandó el link. Esto respondió:', $datos);
                }

                session()->forget('cart');
                return redirect()->away($datos['init_point']); 
                
            } else {
                dd('Mercado Pago rechazó la conexión. Error:', $response->json());
            }
        }
    }

    // CUANDO EL PAGO ES EXITOSO
    public function success(Request $request)
    {
        $order_id = $request->get('external_reference');
        $payment_id = $request->get('payment_id');

        if ($order_id) {
            $order = Order::find($order_id);
            if ($order) {
                // Actualizamos el status de 'pending' a 'paid'
                $order->status = 'paid';
                $order->payment_id = $payment_id;
                $order->save();

                if ($order->user_id) {
                    $user = \App\Models\User::find($order->user_id);
                    $user->points += floor($order->total / 10);
                    $user->save();
                }
            }
        }

        return redirect()->route('pedido')->with('success', '¡Pago aprobado! 💳 Tu pedido ya se está preparando en cocina.');
    }

    // CUANDO EL PAGO FALLA
    public function failure()
    {
        return redirect()->route('pedido')->with('error', 'El pago fue rechazado o cancelado. Tu pedido no se ha procesado.');
    }
}