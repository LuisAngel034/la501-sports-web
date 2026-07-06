<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tag' => 'nullable|string|max:50',
            'price_text' => 'required|string|max:50',
            'icon' => 'nullable|string|max:20',
            'color_gradient' => 'nullable|string',
            'end_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['active'] = 1;

        if ($request->hasFile('image')) {
            try {
                $data['image'] = \App\Services\CloudinaryService::upload($request->file('image'));
            } catch (\Exception $e) {
                return back()->with('error', 'Error al subir la imagen a Cloudinary: ' . $e->getMessage());
            }
        }

        Promotion::create($data);

        return back()->with('success', '¡Promoción creada con éxito!');
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tag' => 'nullable|string|max:50',
            'price_text' => 'required|string|max:50',
            'icon' => 'nullable|string|max:20',
            'color_gradient' => 'nullable|string',
            'end_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            try {
                if ($promotion->image && !str_starts_with($promotion->image, 'http')) {
                    Storage::disk('public')->delete($promotion->image);
                }
                $data['image'] = \App\Services\CloudinaryService::upload($request->file('image'));
            } catch (\Exception $e) {
                return back()->with('error', 'Error al subir la imagen a Cloudinary: ' . $e->getMessage());
            }
        }

        $promotion->update($data);

        return back()->with('success', '¡Promoción actualizada con éxito!');
    }

    public function destroy($id)
    {
        Promotion::destroy($id);
        return back()->with('success', 'Promoción eliminada');
    }
}
