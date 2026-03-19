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
        $lowStockCount = $items->filter(function($item) {
            return $item->current_stock <= $item->min_stock;
        })->count();

        return view('admin.inventory.index', compact('items', 'totalItems', 'lowStockCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|string|max:100',
            'unit'          => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'min_stock'     => 'required|numeric|min:0',
        ]);

        Inventory::create($request->all());

        return back()->with('success', 'Artículo agregado al inventario.');
    }

    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|string|max:100',
            'unit'          => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'min_stock'     => 'required|numeric|min:0',
        ]);

        $item->update($request->all());

        return back()->with('success', 'Artículo actualizado con éxito.');
    }

    public function adjust(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type'   => 'required|in:add,subtract',
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

    // ==========================================
    // EXPORTAR INVENTARIO (CSV PURO)
    // ==========================================
    public function exportCSV()
    {
        $fileName = 'Inventario_La501_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM para que Excel lea los acentos perfecto
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['Nombre', 'Categoria', 'Stock Actual', 'Stock Minimo', 'Unidad'], ';');

            $items = Inventory::orderBy('name', 'asc')->get();

            foreach ($items as $item) {
                fputcsv($file, [
                    $item->name,
                    $item->category,
                    $item->current_stock,
                    $item->min_stock,
                    $item->unit,
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==========================================
    // IMPORTAR INVENTARIO (CSV PURO)
    // ==========================================
    public function importCSV(Request $request)
    {
        $request->validate(['csv_file' => 'required|mimes:csv,txt']);
        $file       = fopen($request->file('csv_file')->getRealPath(), 'r');
        $isFirstRow = true;

        while (($data = fgetcsv($file, 2000, ";")) !== false) {
            // Saltamos la primera fila de cabeceras
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            // Si la fila está vacía, la ignoramos
            if (empty($data[0])) {
                continue;
            }

            Inventory::updateOrCreate(
                ['name' => trim($data[0])],
                [
                    'category'      => $data[1] ?? 'Otros',
                    'current_stock' => (float) ($data[2] ?? 0),
                    'min_stock'     => (float) ($data[3] ?? 0),
                    'unit'          => $data[4] ?? 'pz',
                ]
            );
        }

        fclose($file);
        return back()->with('success', '¡Inventario actualizado desde CSV correctamente!');
    }
}

