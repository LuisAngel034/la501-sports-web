<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicDataController extends Controller
{

    private const PUBLIC_SETTING_KEYS = [
        'business_name',
        'about_us',
        'address_line1',
        'address_line2',
        'address_line3',
        'map_url',
        'phone',
        'telefono',
        'whatsapp',
        'facebook',
        'instagram',
        'schedule_lunes',
        'schedule_martes',
        'schedule_miercoles',
        'schedule_jueves',
        'schedule_viernes',
        'schedule_sabado',
        'schedule_domingo',
    ];

    private const DAYS = [
        'schedule_lunes' => 'lunes',
        'schedule_martes' => 'martes',
        'schedule_miercoles' => 'miércoles',
        'schedule_jueves' => 'jueves',
        'schedule_viernes' => 'viernes',
        'schedule_sabado' => 'sábado',
        'schedule_domingo' => 'domingo',
    ];

    public function info(): JsonResponse
    {
        $settings = Setting::query()
            ->whereIn('key', self::PUBLIC_SETTING_KEYS)
            ->pluck('value', 'key');

        $horarios = collect(self::DAYS)
            ->mapWithKeys(function (string $day, string $key) use ($settings) {
                return [$day => $settings->get($key)];
            })
            ->filter(fn ($value) => filled($value))
            ->all();

        $direccion = collect([
            $settings->get('address_line1'),
            $settings->get('address_line2'),
            $settings->get('address_line3'),
        ])
            ->filter(fn ($value) => filled($value))
            ->implode(', ');

        $horariosUnicos = array_values(
            array_unique(
                array_filter(array_values($horarios))
            )
        );

        $resumenHorario = null;

        if (count($horarios) === 7 && count($horariosUnicos) === 1) {
            $resumenHorario = 'Abrimos todos los días de '
                . $horariosUnicos[0]
                . '.';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $settings->get(
                    'business_name',
                    'La 501 Sports'
                ),

                'about_us' => $settings->get(
                    'about_us',
                    'Restaurante y sports bar donde la pasión por el deporte y la buena comida se unen.'
                ),

                'address' => $direccion,

                'map_url' => $settings->get('map_url'),

                'contact' => [
                    'phone' => $settings->get('phone')
                        ?? $settings->get('telefono'),

                    'whatsapp' => $settings->get('whatsapp'),
                    'facebook' => $settings->get('facebook'),
                    'instagram' => $settings->get('instagram'),
                ],

                'schedule' => $horarios,

                'schedule_summary' => $resumenHorario,
            ],
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function products(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:80'],
            'category' => ['nullable', 'string', 'max:100'],
            'available' => ['nullable', 'boolean'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Product::query()
            ->select([
                'name',
                'description',
                'price',
                'category',
                'available',
            ]);

        if (!empty($validated['q'])) {
            $search = trim($validated['q']);
            $escapedSearch = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);

            $query->where(function ($productQuery) use ($escapedSearch) {
                $productQuery
                    ->where('name', 'LIKE', "%{$escapedSearch}%")
                    ->orWhere('description', 'LIKE', "%{$escapedSearch}%")
                    ->orWhere('category', 'LIKE', "%{$escapedSearch}%");
            });
        }

        if (!empty($validated['category'])) {
            $query->where('category', $validated['category']);
        }

        if (array_key_exists('available', $validated)) {
            $query->where(
                'available',
                filter_var(
                    $validated['available'],
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }

        $limit = $validated['limit'] ?? 50;

        $products = $query
            ->orderBy('category')
            ->orderBy('name')
            ->limit($limit)
            ->get()
            ->map(function (Product $product) {
                return [
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => (float) $product->price,
                    'currency' => 'MXN',
                    'category' => $product->category,
                    'available' => (bool) $product->available,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'total' => $products->count(),
            'data' => $products,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function promotions(): JsonResponse
    {
        $today = now()->toDateString();

        $promotions = Promotion::query()
            ->where('active', 1)
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->select([
                'title',
                'description',
                'active',
                'end_date',
            ])
            ->orderBy('title')
            ->get()
            ->map(function (Promotion $promotion) {
                return [
                    'title' => $promotion->title,
                    'description' => $promotion->description,
                    'active' => (bool) $promotion->active,
                    'end_date' => $promotion->end_date
                        ? (string) $promotion->end_date
                        : null,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'total' => $promotions->count(),
            'data' => $promotions,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function news(): JsonResponse
    {
        $today = now()->toDateString();

        $news = News::query()
            ->where('active', 1)
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->select([
                'title',
                'content',
            ])
            ->latest()
            ->limit(20)
            ->get()
            ->map(function (News $newsItem) {
                return [
                    'title' => $newsItem->title,
                    'content' => $newsItem->content,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'total' => $news->count(),
            'data' => $news,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:80'],
        ]);

        $search = trim($validated['q']);
        $escapedSearch = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
        $today = now()->toDateString();

        $product = Product::query()
            ->select([
                'name',
                'description',
                'price',
                'category',
                'available',
            ])
            ->where(function ($query) use ($escapedSearch) {
                $query
                    ->where('name', 'LIKE', "%{$escapedSearch}%")
                    ->orWhere('description', 'LIKE', "%{$escapedSearch}%")
                    ->orWhere('category', 'LIKE', "%{$escapedSearch}%");
            })
            ->first();

        if ($product) {
            $availabilityMessage = $product->available
                ? 'Actualmente está disponible.'
                : 'Actualmente no está disponible.';

            return response()->json([
                'success' => true,
                'found' => true,
                'type' => 'product',

                'data' => [
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => (float) $product->price,
                    'currency' => 'MXN',
                    'category' => $product->category,
                    'available' => (bool) $product->available,
                ],

                'speech' => sprintf(
                    '%s. %s Tiene un precio de %s pesos. %s',
                    $product->name,
                    $product->description ?: 'Es parte de nuestro menú.',
                    number_format((float) $product->price, 0),
                    $availabilityMessage
                ),
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $promotion = Promotion::query()
            ->where('active', 1)
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->where(function ($query) use ($search) {
                $query
                    ->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->select([
                'title',
                'description',
                'active',
                'end_date',
            ])
            ->first();

        if ($promotion) {
            return response()->json([
                'success' => true,
                'found' => true,
                'type' => 'promotion',

                'data' => [
                    'title' => $promotion->title,
                    'description' => $promotion->description,
                    'active' => true,
                    'end_date' => $promotion->end_date
                        ? (string) $promotion->end_date
                        : null,
                ],

                'speech' => $promotion->title
                    . '. '
                    . $promotion->description,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $newsItem = News::query()
            ->where('active', 1)
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->where(function ($query) use ($search) {
                $query
                    ->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%");
            })
            ->select([
                'title',
                'content',
            ])
            ->first();

        if ($newsItem) {
            return response()->json([
                'success' => true,
                'found' => true,
                'type' => 'news',

                'data' => [
                    'title' => $newsItem->title,
                    'content' => $newsItem->content,
                ],

                'speech' => $newsItem->title
                    . '. '
                    . $newsItem->content,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'success' => true,
            'found' => false,
            'type' => null,
            'data' => null,
            'speech' => 'No encontré información pública relacionada con '
                . $search
                . '.',
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}