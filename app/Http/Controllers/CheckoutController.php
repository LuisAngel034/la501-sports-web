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
                // Si algo se agotó en el último segundo, lo mandamos de regreso al carrito
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
        
        // 1. Validar estado del carrito (Barrera de Seguridad 3)
        $cartValidation = $this->validateCart($cart);
        if ($cartValidation) {
            return $cartValidation;
        }

        // 2. Preparar los datos, crear Orden y Platillos
        $orderData = $this->createOrder($request, $cart);

        // 3. Procesar Pago y retornar la redirección final
        return $this->handlePaymentMethod(
            $request->payment_method,
            $orderData['order'],
            $orderData['total'],
            $orderData['mp_items']
        );
    }

    // =====================================================================
    // Funciones Privadas (Helpers) para reducir la Complejidad Cognitiva
    // =====================================================================

    private function validateCart($cart)
    {
        if (!$cart || count($cart) == 0) {
            return redirect()->route('pedido');
        }

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product || $product->available == 0) {
                return redirect()->route('cart.index')->with('error', 'La compra no pudo completarse porque un platillo ya no está disponible en inventario.');
            }
        }

        return null;
    }

    private function createOrder(Request $request, array $cart): array
    {
        $total = 0;
        $items_mercadopago = [];

        // Calcular totales y armar el arreglo para Mercado Pago
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
            
            $items_mercadopago[] = [
                'title' => $details['name'],
                'quantity' => (int) $details['quantity'],
                'unit_price' => (float) $details['price'],
                'currency_id' => 'MXN',
            ];
        }

        // Guardar la Orden Principal (Siempre inicia como pending)
        $order = Order::create([
            'user_id' => Auth::id(), // Auth::id() retorna null automáticamente si no hay sesión
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Guardar los Platillos
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'subtotal' => $details['price'] * $details['quantity'],
            ]);
        }

        return [
            'order' => $order,
            'total' => $total,
            'mp_items' => $items_mercadopago
        ];
    }

    private function handlePaymentMethod(string $method, Order $order, float $total, array $items_mercadopago)
    {
        // Lógica si es EFECTIVO
        if ($method === 'efectivo') {
            $order->status = 'paid';
            $order->save();

            session()->forget('cart');
            if (Auth::check()) {
                $user = \App\Models\User::find(Auth::id());
                $user->points += floor($total / 10);
                $user->save();

                (new \App\Services\AchievementService())->check($user);
            }
            return redirect()->route('pedido')->with('success', '¡Pedido recibido! Lo prepararemos enseguida y pagarás al recibir.');
        }
        
        // Lógica si es TARJETA (Mercado Pago)
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
        }
        
        dd('Mercado Pago rechazó la conexión. Error:', $response->json());
    }

    // =====================================================================
    // Callbacks de Mercado Pago
    // =====================================================================

    public function success(Request $request)
    {
        $order_id = $request->get('external_reference');
        $payment_id = $request->get('payment_id');

        if ($order_id) {
            $order = Order::find($order_id);
            if ($order) {
                $order->status = 'paid';
                $order->payment_id = $payment_id;
                $order->save();

                if ($order->user_id) {
                    $user = \App\Models\User::find($order->user_id);
                    $user->points += floor($order->total / 10);
                    $user->save();

                    (new \App\Services\AchievementService())->check($user);
                }
            }
        }

        return redirect()->route('pedido')->with('success', '¡Pago aprobado! 💳 Tu pedido ya se está preparando en cocina.');
    }

    public function failure()
    {
        return redirect()->route('pedido')->with('error', 'El pago fue rechazado o cancelado. Tu pedido no se ha procesado.');
    }
}
