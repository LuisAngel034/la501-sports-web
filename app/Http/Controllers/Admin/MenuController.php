<?php

namespace App\Http\Controllers\Admin;

use App\Events\MenuUpdated;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Ingrediente;
use App\Traits\CsvExporter; // <--- Importante
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    use CsvExporter; // <--- Implementar el Trait

    public function index()
    {
        $products = Product::all();
        $inventario = \App\Models\Inventory::select('id', 'name')->get();
        return view('admin.menu', compact('products', 'inventario'));
    }

    // ... (métodos store, update y destroy se mantienen igual)

    public function exportCSV()
    {
        $fileName = 'Menu_La501_' . date('Y-m-d') . '.csv';
        $headers = $this->getCsvHeaders($fileName);

        $callback = function () {
            $file = fopen('php://output', 'w');
            $this->insertBom($file);

            fputcsv($file, ['Nombre', 'Precio', 'Categoria', 'Subcategoria', 'Descripcion', 'Disponible'], ',');

            Product::all()->each(function ($product) use ($file) {
                fputcsv($file, [
                    $product->name,
                    $product->price,
                    $product->category,
                    $product->subcategory,
                    $product->description,
                    $product->available ? 'Si' : 'No',
                ], ',');
            });
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadTemplate()
    {
        $fileName = 'Plantilla_Menu_La501.csv';
        $headers = $this->getCsvHeaders($fileName);

        $callback = function () {
            $file = fopen('php://output', 'w');
            $this->insertBom($file);
            fputcsv($file, ['Nombre', 'Precio', 'Categoria', 'Subcategoria', 'Descripcion', 'Disponible'], ',');
            fputcsv($file, ['Hamburguesa Clasica', '120.50', 'Hamburguesas', '', 'Carne de res, queso, lechuga y tomate', 'Si'], ',');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCSV(Request $request)
    {
        $request->validate(['csv_file' => 'required|mimes:csv,txt|max:2048']);
        $file = fopen($request->file('csv_file')->getRealPath(), 'r');
        $isFirstRow = true;

        while (($data = fgetcsv($file, 2000, ",")) !== false) {
            if ($isFirstRow || !isset($data[0]) || trim($data[0]) === '') {
                $isFirstRow = false;
                continue;
            }

            $disponible = (isset($data[5]) && strtolower(trim($data[5])) === 'no') ? 0 : 1;

            Product::updateOrCreate(
                ['name' => trim($data[0])],
                [
                    'price'       => (float) ($data[1] ?? 0),
                    'category'    => trim($data[2] ?? 'General'),
                    'subcategory' => trim($data[3] ?? ''),
                    'description' => trim($data[4] ?? ''),
                    'available'   => $disponible,
                ]
            );
        }
        fclose($file);
        event(new MenuUpdated());
        return back()->with('success', '¡Menú actualizado con éxito!');
    }
}
