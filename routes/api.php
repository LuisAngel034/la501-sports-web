<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// ── Menú ──────────────────────────────────────────
Route::get('/alexa/menu', function () {
    $categoria = request('categoria');

    $query = DB::table('products')->where('available', 1);

    if ($categoria) {
        $query->where('category', $categoria);
    }

    $platillos = $query->select('name', 'price', 'category', 'description')
                       ->orderBy('category')
                       ->orderBy('price')
                       ->limit(20)
                       ->get()
                       ->map(fn($p) => [
                           'nombre'      => $p->name,
                           'precio'      => '$' . number_format($p->price, 0),
                           'categoria'   => $p->category,
                           'descripcion' => $p->description,
                       ]);

    return response()->json([
        'total'     => $platillos->count(),
        'platillos' => $platillos,
    ]);
});

// ── Promociones ───────────────────────────────────
Route::get('/alexa/promociones', function () {
    $promos = DB::table('promotions')
        ->where('active', 1)
        ->select('title', 'description', 'price_text', 'tag', 'end_date')
        ->orderBy('id')
        ->get()
        ->map(fn($p) => [
            'titulo'      => $p->title,
            'descripcion' => $p->description,
            'precio'      => $p->price_text,
            'etiqueta'    => $p->tag,
            'vigencia'    => $p->end_date ?? 'Sin fecha límite',
        ]);

    return response()->json([
        'total'       => $promos->count(),
        'promociones' => $promos,
    ]);
});

// ── Horarios ──────────────────────────────────────
Route::get('/alexa/horarios', function () {
    $claves = [
        'schedule_lunes', 'schedule_martes', 'schedule_miercoles',
        'schedule_jueves', 'schedule_viernes', 'schedule_sabado', 'schedule_domingo',
        'address_line1', 'address_line2', 'address_line3',
    ];

    $rows  = DB::table('settings')->whereIn('key', $claves)->pluck('value', 'key');
    $dias  = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];

    $horarios = [];
    foreach ($dias as $dia) {
        $k = "schedule_$dia";
        if (isset($rows[$k])) {
            $horarios[ucfirst($dia)] = $rows[$k];
        }
    }

    $direccion = collect(['address_line1','address_line2','address_line3'])
        ->map(fn($k) => $rows[$k] ?? '')
        ->filter()
        ->implode(', ');

    return response()->json([
        'horarios'  => $horarios,
        'direccion' => $direccion,
    ]);
});

// ── Reservaciones ─────────────────────────────────
Route::get('/alexa/reservaciones', function () {
    $fecha = request('fecha', now()->toDateString());

    $reservas = DB::table('reservations')
        ->where('fecha_reservacion', $fecha)
        ->whereIn('status', ['pendiente', 'confirmada'])
        ->select('hora_reservacion', 'cantidad_personas', 'zona', 'status')
        ->orderBy('hora_reservacion')
        ->get()
        ->map(fn($r) => [
            'hora'     => substr($r->hora_reservacion, 0, 5),
            'personas' => $r->cantidad_personas,
            'zona'     => $r->zona,
            'estatus'  => $r->status,
        ]);

    return response()->json([
        'fecha'                  => $fecha,
        'reservaciones_activas'  => $reservas->count(),
        'detalle'                => $reservas,
    ]);
});