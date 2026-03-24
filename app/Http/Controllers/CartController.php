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
            $product = Product::find($id);

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
            'image' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        $id = $request->id;

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => $request->quantity,
                "price" => $request->price,
                "image" => $request->image
            ];
        }

        session()->put('cart', $cart);

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
            return back()->with('success', 'Platillo eliminado del carrito.');
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

        return back();
    }
}
