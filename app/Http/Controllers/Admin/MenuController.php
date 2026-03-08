<?php

namespace App\Http\Controllers\Admin;

use App\Events\MenuUpdated;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
{
    $products = Product::all();
    
    $inventario = \App\Models\Inventory::select('id', 'name')->get();

    return view('admin.menu', compact('products', 'inventario'));
}

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'image' => $imagePath,
            'available' => $request->has('available') ? 1 : 0,
        ]);

        if ($request->ingredients && is_array($request->ingredients)) {
            foreach ($request->ingredients as $item) {
                if (!empty($item)) {
                    Ingrediente::create([
                        'product_id' => $product->id,
                        'nombre'     => $item
                    ]);
                }
            }
        }

        event(new MenuUpdated());

        return back()->with('success', 'Platillo guardado correctamente');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        
        event(new MenuUpdated());

        return back()->with('success', 'Platillo eliminado correctamente');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'available' => $request->has('available') ? 1 : 0,
        ]);

        if ($request->ingredients) {
            $product->ingredientes()->delete();
            foreach ($request->ingredients as $item) {
                if (!empty($item)) {
                    Ingrediente::create([
                        'product_id' => $product->id,
                        'nombre' => $item
                    ]);
                }
            }
        }

        event(new MenuUpdated());
        
        return back()->with('success', 'Platillo actualizado correctamente');
    }

    public function apiProducts()
    {
        $products = Product::where('available', 1)->get(); 
        return response()->json($products);
    }
}