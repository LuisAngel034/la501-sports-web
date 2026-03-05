<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::orderBy('name', 'asc')->get();
        
        $totalItems = $items->count();
        $lowStockCount = $items->where('current_stock', '<=', 'min_stock')->count();

        return view('admin.inventory.index', compact('items', 'totalItems', 'lowStockCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
        ]);

        Inventory::create($request->all());

        return back()->with('success', 'Artículo agregado al inventario.');
    }

    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
        ]);

        $item->update($request->all());

        return back()->with('success', 'Artículo actualizado con éxito.');
    }
    
    public function adjust(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);
        
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:add,subtract'
        ]);

        if ($request->type === 'add') {
            $item->current_stock += $request->amount;
        } else {
            $item->current_stock = max(0, $item->current_stock - $request->amount);
        }

        $item->save();

        return back()->with('success', 'Stock actualizado correctamente.');
    }

    public function destroy($id)
    {
        Inventory::destroy($id);
        return back()->with('success', 'Artículo eliminado del inventario.');
    }
}