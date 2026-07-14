<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartChanged = false;
        $total = 0;

        foreach ($cart as $id => $details) {
            $productId = $details['id'] ?? $id;
            $product = Product::find($productId);

            if (!$product || $product->available == 0) {
                unset($cart[$id]);
                $cartChanged = true;
            }
            else {
                if ($cart[$id]['price'] != $product->price) {
                    $cart[$id]['price'] = $product->price;
                    $cartChanged = true;
                }
                $total += $cart[$id]['price'] * $cart[$id]['quantity'];
            }
        }

        if ($cartChanged) {
            session()->put('cart', $cart);
            session()->flash('error', 'Algunos platillos de tu carrito se agotaron o cambiaron de precio y fueron actualizados automáticamente.');
        }

        return view('carrito', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|string',
            'excluded_ingredients' => 'nullable|array'
        ]);

        $cart = session()->get('cart', []);
        $id = $request->id;
        
        $excluded = $request->input('excluded_ingredients', []);
        sort($excluded);
        $cartKey = empty($excluded) ? $id : $id . '_' . md5(json_encode($excluded));

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                "id" => (int)$id,
                "name" => $request->name,
                "quantity" => $request->quantity,
                "price" => $request->price,
                "image" => $request->image,
                "excluded_ingredients" => $excluded
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'total_items' => count((array)$cart),
                'message' => '¡Platillo agregado al carrito!'
            ]);
        }

        return back()->with('success', '¡Platillo agregado al carrito!');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'cart' => $cart,
                    'total_items' => count((array)$cart),
                    'message' => 'Platillo eliminado del carrito.'
                ]);
            }
            return back()->with('success', 'Platillo eliminado del carrito.');
        }
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'ID no proporcionado.'
            ], 400);
        }
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Carrito vaciado.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|numeric'
        ]);

        $cart = session()->get('cart');

        if(isset($cart[$request->id])) {
            if($request->quantity <= 0) {
                unset($cart[$request->id]);
            } else {
                $cart[$request->id]['quantity'] = $request->quantity;
            }
            session()->put('cart', $cart);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'total_items' => count((array)$cart),
                'message' => 'Carrito actualizado.'
            ]);
        }

        return back();
    }
}
