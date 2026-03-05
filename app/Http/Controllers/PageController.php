<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\News;
use App\Models\Promotion;

class PageController extends Controller
{
    public function index() {
        $products = \App\Models\Product::where('available', 1)->get(); 
        return view('pedido', compact('products')); 
    }

    public function novedades()
    {
        $today = now()->toDateString(); 

        $baseQuery = News::where('active', 1)
            ->where(function ($query) use ($today) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            });

        $deportes = (clone $baseQuery)->where('category', 'Deportes')->orderBy('created_at', 'desc')->get();
        $avisos = (clone $baseQuery)->where('category', 'Aviso')->orderBy('created_at', 'desc')->get();
        $eventos = (clone $baseQuery)->where('category', 'Evento')->orderBy('created_at', 'desc')->get();

        return view('novedades', compact('deportes', 'avisos', 'eventos'));
    }

    public function promociones()
    {
        $today = now()->toDateString();

        $promotions = Promotion::where('active', 1)
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('promociones', compact('promotions'));
    }
}
