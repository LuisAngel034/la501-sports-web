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
        $products   = Product::all();
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
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'subcategory' => $request->subcategory,
            'image'       => $imagePath,
            'available'   => $request->has('available') ? 1 : 0,
        ]);

        if ($request->ingredients && is_array($request->ingredients)) {
            foreach ($request->ingredients as $item) {
                if (!empty($item)) {
                    Ingrediente::create([
                        'product_id' => $product->id,
                        'nombre'     => $item,
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
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'subcategory' => $request->subcategory,
            'available'   => $request->has('available') ? 1 : 0,
        ]);

        if ($request->ingredients) {
            $product->ingredientes()->delete();
            foreach ($request->ingredients as $item) {
                if (!empty($item)) {
                    Ingrediente::create([
                        'product_id' => $product->id,
                        'nombre'     => $item,
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

    // ==========================================
    // EXPORTAR MENÚ (Plantilla Excel)
    // ==========================================
    public function exportCSV()
    {
        $fileName = 'Menu_La501_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM para Excel
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // AQUÍ SE CAMBIÓ A COMA
            fputcsv($file, ['Nombre', 'Precio', 'Categoria', 'Subcategoria', 'Descripcion', 'Disponible'], ',');

            $products = \App\Models\Product::all();

            foreach ($products as $product) {
                // AQUÍ SE CAMBIÓ A COMA
                fputcsv($file, [
                    $product->name,
                    $product->price,
                    $product->category,
                    $product->subcategory,
                    $product->description,
                    $product->available ? 'Si' : 'No',
                ], ',');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==========================================
    // DESCARGAR PLANTILLA DE MENÚ (Ejemplo vacío)
    // ==========================================
    public function downloadTemplate()
    {
        $fileName = 'Plantilla_Menu_La501.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM para que Excel lea bien los acentos
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // AQUÍ SE CAMBIÓ A COMA
            fputcsv($file, ['Nombre', 'Precio', 'Categoria', 'Subcategoria', 'Descripcion', 'Disponible'], ',');

            // AQUÍ SE CAMBIÓ A COMA
            fputcsv($file, ['Hamburguesa Clasica', '120.50', 'Hamburguesas', '', 'Carne de res, queso, lechuga y tomate', 'Si'], ',');
            fputcsv($file, ['Margarita', '95.00', 'Coctelería', 'Tequila', 'Cóctel clásico con limón y sal', 'Si'], ',');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==========================================
    // IMPORTAR MENÚ (Actualizar o Crear masivo)
    // ==========================================
    public function importCSV(Request $request)
    {
        $request->validate(['csv_file' => 'required|mimes:csv,txt|max:2048']);
        $file       = fopen($request->file('csv_file')->getRealPath(), 'r');
        $isFirstRow = true;

        // AQUÍ SE CAMBIÓ A COMA
        while (($data = fgetcsv($file, 2000, ",")) !== false) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            // Si la fila está vacía, saltar
            if (!isset($data[0]) || trim($data[0]) === '') {
                continue;
            }

            $disponible = (isset($data[5]) && strtolower(trim($data[5])) === 'no') ? 0 : 1;

            \App\Models\Product::updateOrCreate(
                ['name' => trim($data[0])],
                [
                    'price'       => isset($data[1]) ? (float) $data[1] : 0,
                    'category'    => trim($data[2] ?? 'General'),
                    'subcategory' => trim($data[3] ?? ''),
                    'description' => trim($data[4] ?? ''),
                    'available'   => $disponible,
                ]
            );
        }

        fclose($file);

        event(new MenuUpdated());

        return redirect()->back()->with('success', '¡El menú fue importado y actualizado con éxito!');
    }
}