<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Traits\CsvExporter; // <--- Importante
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    use CsvExporter; // <--- Implementar el Trait

    public function index()
    {
        $items = Inventory::orderBy('name', 'asc')->get();
        $totalItems = $items->count();
        $lowStockCount = $items->filter(fn($item) => $item->current_stock <= $item->min_stock)->count();

        return view('admin.inventory.index', compact('items', 'totalItems', 'lowStockCount'));
    }

    // ... (métodos store, update, adjust y destroy se mantienen igual)

    public function exportCSV()
    {
        $fileName = 'Inventario_La501_' . date('Y-m-d') . '.csv';
        $headers = $this->getCsvHeaders($fileName);

        $callback = function () {
            $file = fopen('php://output', 'w');
            $this->insertBom($file);
            fputcsv($file, ['Nombre', 'Categoria', 'Stock Actual', 'Stock Minimo', 'Unidad'], ',');

            Inventory::orderBy('name', 'asc')->each(function ($item) use ($file) {
                fputcsv($file, [
                    $item->name,
                    $item->category,
                    $item->current_stock,
                    $item->min_stock,
                    $item->unit,
                ], ',');
            });
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadTemplate()
    {
        $fileName = 'Plantilla_Inventario_La501.csv';
        $headers = $this->getCsvHeaders($fileName);

        $callback = function () {
            $file = fopen('php://output', 'w');
            $this->insertBom($file);
            fputcsv($file, ['Nombre', 'Categoria', 'StockActual', 'StockMinimo', 'Unidad'], ',');
            fputcsv($file, ['Carne de Res Premium', 'Carnes', '25.5', '5.0', 'kg'], ',');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCSV(Request $request)
    {
        $request->validate(['csv_file' => 'required|mimes:csv,txt']);
        $file = fopen($request->file('csv_file')->getRealPath(), 'r');
        $isFirstRow = true;

        while (($data = fgetcsv($file, 2000, ",")) !== false) {
            if ($isFirstRow || empty($data[0])) {
                $isFirstRow = false;
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
        return back()->with('success', '¡Inventario actualizado correctamente!');
    }
}
