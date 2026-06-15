<?php

use Illuminate\Support\Facades\Route;

// 1. Públicos y Autenticación
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;

// 2. Empleados
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\Admin\DashboardExportController;

// 3. Administrador
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\Admin\DatabaseController;

$promoPrefix = 'promociones';

/*
|--------------------
| 1. RUTAS PÚBLICAS
|--------------------
*/
Route::get('/', function () { return view('quienes-somos'); })->name('nosotros');
Route::get('/contacto', function () { return view('contacto'); })->name('contacto');
Route::get('/reservaciones', function () { return view('reservaciones'); })->name('reservaciones');
Route::post('/reservaciones/store', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/ubicacion', function () { return view('ubicacion'); })->name('ubicacion');

Route::get('/a-domicilio', [PageController::class, 'index'])->name('pedido');
Route::get('/novedades', [PageController::class, 'novedades'])->name('novedades');
Route::get("/{$promoPrefix}", [PageController::class, 'promociones'])->name('promociones');
Route::post('/contacto/enviar', [PageController::class, 'enviarContacto'])->name('contacto.enviar');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/api/menu/products', function() {
    return response()->json(\App\Models\Product::where('available', 1)->get());
})->name('api.menu.products');

Route::get('/api/alexa/menu', function () {
    $categoria = request('categoria');
    $query = \App\Models\Product::where('available', 1);
    if ($categoria) $query->where('category', $categoria);
    
    $platillos = $query->select('name', 'price', 'category', 'description')
        ->orderBy('category')->orderBy('price')->limit(20)->get()
        ->map(fn($p) => [
            'nombre'      => $p->name,
            'precio'      => '$' . number_format($p->price, 0),
            'categoria'   => $p->category,
            'descripcion' => $p->description,
        ]);
    return response()->json(['total' => $platillos->count(), 'platillos' => $platillos]);
});

Route::get('/api/alexa/promociones', function () {
    $promos = \App\Models\Promotion::where('active', 1)->get()
        ->map(fn($p) => [
            'titulo'      => $p->title,
            'descripcion' => $p->description,
            'precio'      => $p->price_text,
            'etiqueta'    => $p->tag,
            'vigencia'    => $p->end_date ?? 'Sin fecha límite',
        ]);
    return response()->json(['total' => $promos->count(), 'promociones' => $promos]);
});

Route::get('/api/alexa/horarios', function () {
    $claves = [
        'schedule_lunes','schedule_martes','schedule_miercoles','schedule_jueves',
        'schedule_viernes','schedule_sabado','schedule_domingo',
        'address_line1','address_line2','address_line3',
    ];
    $rows = \App\Models\Setting::whereIn('key', $claves)->pluck('value', 'key');
    
    $horarios = [];
    foreach (['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $dia) {
        if (isset($rows["schedule_$dia"])) $horarios[ucfirst($dia)] = $rows["schedule_$dia"];
    }
    $direccion = collect(['address_line1','address_line2','address_line3'])
        ->map(fn($k) => $rows[$k] ?? '')->filter()->implode(', ');
    
    return response()->json(['horarios' => $horarios, 'direccion' => $direccion]);
});

Route::get('/api/alexa/reservaciones', function () {
    $fecha = request('fecha', now()->toDateString());
    $reservas = \App\Models\Reservation::where('fecha_reservacion', $fecha)
        ->whereIn('status', ['pendiente','confirmada'])
        ->orderBy('hora_reservacion')->get()
        ->map(fn($r) => [
            'hora'     => substr($r->hora_reservacion, 0, 5),
            'personas' => $r->cantidad_personas,
            'zona'     => $r->zona,
            'estatus'  => $r->status,
        ]);
    return response()->json([
        'fecha'                 => $fecha,
        'reservaciones_activas' => $reservas->count(),
        'detalle'               => $reservas,
    ]);
});

Route::get('/api/alexa/faq', function () {
    $tema = request('tema');
    
    $faq = \App\Models\Faq::where('tema', 'LIKE', "%{$tema}%")->first();
    
    if ($faq) {
        return response()->json(['encontrado' => true, 'respuesta' => $faq->respuesta]);
    }
    
    return response()->json(['encontrado' => false, 'respuesta' => 'Lo siento, no tengo información sobre eso.']);
});

Route::get('/api/alexa/busqueda', function () {
    $query = request('q');

    if (!$query) {
        return response()->json([
            'encontrado' => false, 
            'respuesta' => '¿Qué te gustaría saber sobre nuestro menú o promociones?'
        ]);
    }

    $query = trim($query);

    $producto = \App\Models\Product::where('available', 1)
        ->where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->first();

    if ($producto) {
        $msg = "Sí, en nuestro menú tenemos " . $producto->name;
        if ($producto->description) {
            $msg .= ", que consiste en " . $producto->description;
        }
        $msg .= ". Tiene un precio de $" . number_format($producto->price, 0) . ".";
        
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    $promocion = \App\Models\Promotion::where('active', 1)
        ->where(function($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->first();

    if ($promocion) {
        $msg = "Tenemos una promoción activa llamada: " . $promocion->title . ". " . $promocion->description;
        if ($promocion->price_text) {
            $msg .= " por solo " . $promocion->price_text . ".";
        }
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    $productoPorCategoria = \App\Models\Product::where('available', 1)
        ->where('category', 'LIKE', "%{$query}%")
        ->first();

    if ($productoPorCategoria) {
        $ejemplos = \App\Models\Product::where('available', 1)
            ->where('category', $productoPorCategoria->category)
            ->limit(3)
            ->pluck('name')
            ->implode(', ');

        $msg = "Sí, en la categoría de " . $productoPorCategoria->category . " te puedo ofrecer opciones como: " . $ejemplos . ".";
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    return response()->json([
        'encontrado' => false,
        'respuesta' => "Lo siento, busqué en nuestros datos públicos pero no encontré información sobre '" . $query . "'. ¿Te gustaría preguntar por otro platillo o promoción?"
    ]);
});
Route::get('/api/alexa/busqueda', function () {
    $rawQuery = request('q');

    if (!$rawQuery) {
        return response()->json([
            'encontrado' => false, 
            'respuesta' => '¿Qué te gustaría saber sobre nuestro menú o promociones?'
        ]);
    }

    $words = explode(' ', mb_strtolower(trim($rawQuery), 'UTF-8'));
    $fillerWords = [
        'quiero', 'saber', 'si', 'tienen', 'tiene', 'hay', 'un', 'una', 'unos', 'unas', 
        'de', 'del', 'el', 'la', 'los', 'las', 'por', 'favor', 'me', 'puedes', 'decir', 
        'precio', 'venden', 'vende', 'sobre', 'buscar', 'busca', 'algo', 'que', 'en', 'para'
    ];
    
    $filteredWords = array_diff($words, $fillerWords);
    $query = implode(' ', $filteredWords);
    
    if (empty(trim($query))) {
        $query = trim($rawQuery);
    }

    $productoPorNombre = \App\Models\Product::where('available', 1)
        ->where('name', 'LIKE', "%{$query}%")
        ->first();

    if ($productoPorNombre) {
        $msg = "Sí, en nuestro menú tenemos " . $productoPorNombre->name;
        if ($productoPorNombre->description) {
            $msg .= ", que consiste en " . $productoPorNombre->description;
        }
        $msg .= ". Tiene un precio de $" . number_format($productoPorNombre->price, 0) . ".";
        
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    $promocionPorTitulo = \App\Models\Promotion::where('active', 1)
        ->where('title', 'LIKE', "%{$query}%")
        ->first();

    if ($promocionPorTitulo) {
        $msg = "Tenemos una promoción activa para eso: " . $promocionPorTitulo->title . ". " . $promocionPorTitulo->description;
        if ($promocionPorTitulo->price_text) {
            $msg .= " por solo " . $promocionPorTitulo->price_text . ".";
        }
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    $productoPorCategoria = \App\Models\Product::where('available', 1)
        ->where('category', 'LIKE', "%{$query}%")
        ->first();

    if ($productoPorCategoria) {
        $ejemplos = \App\Models\Product::where('available', 1)
            ->where('category', $productoPorCategoria->category)
            ->limit(3)
            ->pluck('name')
            ->implode(', ');

        $msg = "Sí, en la sección de " . $productoPorCategoria->category . " te puedo ofrecer opciones como: " . $ejemplos . ".";
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    $productoPorDescripcion = \App\Models\Product::where('available', 1)
        ->where('description', 'LIKE', "%{$query}%")
        ->first();

    if ($productoPorDescripcion) {
        $msg = "No encontré un platillo llamado '" . $query . "', pero nuestro platillo '" . $productoPorDescripcion->name . "' lo incluye. Su precio es de $" . number_format($productoPorDescripcion->price, 0) . ".";
        return response()->json(['encontrado' => true, 'respuesta' => $msg]);
    }

    return response()->json([
        'encontrado' => false,
        'respuesta' => "Lo siento, busqué en el menú y promociones de hoy pero no encontré nada relacionado con '" . $query . "'. ¿Te gustaría intentar buscando otra cosa?"
    ]);
});

Route::get('/api/alexa/contexto-publico', function () {
    $claves = [
        'schedule_lunes','schedule_martes','schedule_miercoles','schedule_jueves',
        'schedule_viernes','schedule_sabado','schedule_domingo',
        'address_line1','address_line2','address_line3',
        'phone','telefono','whatsapp','facebook','instagram'
    ];

    $settings = \App\Models\Setting::whereIn('key', $claves)->pluck('value', 'key');

    $horarios = [];
    foreach (['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $dia) {
        $key = "schedule_$dia";
        if (isset($settings[$key])) {
            $horarios[ucfirst($dia)] = $settings[$key];
        }
    }

    $direccion = collect(['address_line1','address_line2','address_line3'])
        ->map(fn($k) => $settings[$k] ?? '')
        ->filter()
        ->implode(', ');

    $menu = \App\Models\Product::where('available', 1)
        ->select('name', 'description', 'price', 'category')
        ->orderBy('category')
        ->orderBy('price')
        ->get()
        ->groupBy('category')
        ->map(function ($items) {
            return $items->map(fn($p) => [
                'nombre' => $p->name,
                'descripcion' => $p->description,
                'precio' => '$' . number_format($p->price, 0),
            ])->values();
        });

    $promociones = \App\Models\Promotion::where('active', 1)
        ->select('title', 'description', 'price_text', 'tag', 'end_date')
        ->get()
        ->map(fn($p) => [
            'titulo' => $p->title,
            'descripcion' => $p->description,
            'precio' => $p->price_text,
            'etiqueta' => $p->tag,
            'vigencia' => $p->end_date ?? 'Sin fecha límite',
        ]);

    $novedades = \App\Models\News::where('active', 1)
        ->where(function ($q) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', now()->toDateString());
        })
        ->where(function ($q) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
        })
        ->select('title', 'content', 'category', 'start_date', 'end_date')
        ->latest()
        ->limit(5)
        ->get()
        ->map(fn($n) => [
            'titulo' => $n->title,
            'contenido' => $n->content,
            'categoria' => $n->category,
            'vigencia' => trim(($n->start_date ?? '') . ' a ' . ($n->end_date ?? '')),
        ]);

    $reservacionesHoy = \App\Models\Reservation::where('fecha_reservacion', now()->toDateString())
        ->whereIn('status', ['pendiente', 'confirmada'])
        ->count();

    return response()->json([
        'restaurante' => [
            'nombre' => 'La 501 Sports',
            'descripcion' => 'Restaurante y sports bar donde la pasión por el deporte y la buena comida se unen para crear momentos inolvidables.',
            'direccion' => $direccion,
            'contacto' => [
                'telefono' => $settings['phone'] ?? $settings['telefono'] ?? null,
                'whatsapp' => $settings['whatsapp'] ?? null,
                'facebook' => $settings['facebook'] ?? null,
                'instagram' => $settings['instagram'] ?? null,
            ],
        ],
        'horarios' => $horarios,
        'menu' => $menu,
        'promociones' => $promociones,
        'novedades' => $novedades,
        'reservaciones' => [
            'fecha' => now()->toDateString(),
            'reservaciones_activas' => $reservacionesHoy,
            'nota' => 'Las reservaciones están sujetas a disponibilidad y confirmación del personal.',
        ],
    ], 200, [], JSON_UNESCAPED_UNICODE);
});

// Carrito de Compras
Route::controller(CartController::class)->group(function () {
    Route::get('/carrito', 'index')->name('cart.index');
    Route::post('/carrito/agregar', 'add')->name('cart.add');
    Route::post('/carrito/actualizar', 'update')->name('cart.update');
    Route::delete('/carrito/eliminar', 'remove')->name('cart.remove');
    Route::post('/carrito/vaciar', 'clear')->name('cart.clear');
});

// Pagos y Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/procesar', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/pago/exitoso', [CheckoutController::class, 'success'])->name('payment.success');
Route::get('/pago/fallido', [CheckoutController::class, 'failure'])->name('payment.failure');

/*
|-----------------------------
| 2. RUTAS DE AUTENTICACIÓN
|-----------------------------
*/
Route::controller(AuthController::class)->group(function () {
    // Ingreso y Registro
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/registro', 'showRegistro')->name('register');
    Route::post('/registro', 'registrar');
    Route::post('/logout', 'logout')->name('logout');

    // Recuperación
    Route::get('/recuperar', 'showRecuperar')->name('password.request');
    Route::post('/recuperar', 'enviarCodigo')->name('password.email');
    Route::get('/recuperar/verificar-codigo', 'showVerifyCode')->name('password.verify.code');
    Route::post('/recuperar/verificar-codigo', 'verifyCode')->name('password.verify.code.post');
    Route::get('/recuperar/nueva-password', 'showCustomResetForm')->name('password.reset.form');
    Route::post('/recuperar/nueva-password', 'updateCustomPassword')->name('password.update');
});

/*
|------------------------------------------------
| 3. RUTAS PRIVADAS (Solo usuarios logueados)
|------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Clientes
    Route::get('/perfil', [AuthController::class, 'showPerfil'])->name('perfil');
    Route::post('/perfil', [AuthController::class, 'updatePerfil'])->name('perfil.update');

    // Meseros
    Route::prefix('mesero')->group(function () {
        Route::get('/mesas', [WaiterController::class, 'index'])->name('mesero.mesas');
        Route::get('/mesas/{id}/pedido', [WaiterController::class, 'tomarPedido'])->name('mesero.pedido');
        Route::put('/mesas/{id}/cobrar', [WaiterController::class, 'cobrar'])->name('mesero.cobrar');
        Route::post('/mesas/{id}/pedido', [WaiterController::class, 'guardarPedido'])->name('mesero.guardar_pedido');
        
    });

    // Solo para activar el enlace en el servidor
    Route::get('/link-storage', function () {
        Artisan::call('storage:link');
        return "Enlace creado con éxito";
    });
});

/*
|------------------------------------------------------
| 4. RUTAS DEL ADMINISTRADOR (Protegidas y Seguras)
|------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () use ($promoPrefix) {

    Route::get('/reservaciones', [ReservationAdminController::class, 'index'])->name('admin.reservations.index');
    
    Route::patch('/reservations/{reservation}/status/{status}', [ReservationAdminController::class, 'updateStatus'])
        ->name('admin.reservations.update-status');

    // Dashboard y API de Gráficas/Estadísticas
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/exportar-ventas', [DashboardController::class, 'exportSalesCSV'])->name('admin.sales.export.excel');
    Route::get('/api/stats', [DashboardController::class, 'apiStats'])->name('admin.api.stats');
    Route::get('/api/sales', [DashboardController::class, 'apiSales'])->name('admin.api.sales');
    
    // Rutas de AdminController
    Route::get('/ventas', [AdminController::class, 'ventas'])->name('admin.ventas');
    Route::get('/api/sales-data', [AdminController::class, 'getSalesData']);
    Route::get('/api/orders/latest', function() {
        return \App\Models\Order::with('items')->latest()->take(10)->get();
    })->name('admin.api.orders');
    

    // Gestión de Mensajes (CRM)
    Route::get('/mensajes', [AdminController::class, 'mensajes'])->name('admin.mensajes');
    Route::put('/mensajes/{id}/marcar-leido', [AdminController::class, 'marcarRespondido'])->name('admin.mensajes.leido');

    // Gestión del Menú
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('admin.menu');
    Route::get('/menu/exportar', [AdminMenuController::class, 'exportCSV'])->name('admin.menu.export');
    Route::get('/menu/plantilla', [AdminMenuController::class, 'downloadTemplate'])->name('admin.menu.template');
    Route::post('/menu/importar', [AdminMenuController::class, 'importCSV'])->name('admin.menu.import');
    Route::post('/menu/store', [AdminMenuController::class, 'store'])->name('admin.menu.store');
    Route::put('/menu/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/menu/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');
    Route::get('/admin/menu/template', [MenuController::class, 'downloadTemplate'])->name('admin.menu.template');
    
    // Gestión de Usuarios / Empleados
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/usuarios/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/usuarios/{id}/toggle', [UserController::class, 'toggleStatus'])->name('admin.users.toggle');

    // Gestión de Novedades
    Route::get('/novedades', [NewsController::class, 'index'])->name('admin.news');
    Route::post('/novedades/store', [NewsController::class, 'store'])->name('admin.news.store');
    Route::put('/novedades/{id}', [NewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/novedades/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');

    // Gestión de Promociones
    Route::prefix($promoPrefix)->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('admin.promotions.index');
        Route::post('/', [PromotionController::class, 'store'])->name('admin.promotions.store');
        Route::put('/{id}', [PromotionController::class, 'update'])->name('admin.promotions.update');
        Route::delete('/{id}', [PromotionController::class, 'destroy'])->name('admin.promotions.destroy');
    });

    // Configuración General
    Route::controller(SettingController::class)->prefix('configuracion')->group(function () {
        Route::get('/', 'index')->name('admin.settings.index');
        Route::post('/logo', 'updateLogo')->name('admin.settings.logo');
        Route::post('/mapa', 'updateMap')->name('admin.settings.map');
        Route::post('/direccion', 'updateAddress')->name('admin.settings.address');
        Route::post('/horarios', 'updateSchedule')->name('admin.settings.schedule');
    });

    // Gestión de Finanzas
    Route::resource('finanzas', FinanceController::class)->only(['index', 'store', 'destroy'])->names('admin.finances');

    // Gestión de Inventario
    Route::get('/inventario/exportar', [InventoryController::class, 'exportCSV'])->name('admin.inventory.export');
    Route::get('/inventario/plantilla', [InventoryController::class, 'downloadTemplate'])->name('admin.inventory.template');
    Route::post('/inventario/importar', [InventoryController::class, 'importCSV'])->name('admin.inventory.import');
    Route::resource('inventario', InventoryController::class)->except(['create', 'show', 'edit'])->names('admin.inventory');
    Route::put('/inventario/{id}/ajustar', [InventoryController::class, 'adjust'])->name('admin.inventory.adjust');
    Route::get('/inventario/plantilla', [InventoryController::class, 'downloadTemplate'])->name('admin.inventory.template');

    // ==========================================================
    // SISTEMA Y BASE DE DATOS (Módulo Avanzado)
    // ==========================================================
    Route::prefix('sistema/base-de-datos')->group(function () {
        // Vistas principales
        Route::get('/', [AdminController::class, 'database'])->name('admin.database');
        Route::get('/historial', [BackupController::class, 'databaseHistory'])->name('admin.database.history');
        
        Route::get('/monitoreo', [AdminController::class, 'monitor'])->name('admin.database.monitor');

        // Acciones de Respaldo
        Route::post('/backup', [AdminController::class, 'createBackup'])->name('admin.database.backup');
        Route::post('/descargar', [AdminController::class, 'downloadBackup'])->name('admin.database.download');

        Route::post('/auto', [AdminController::class, 'saveAuto'])->name('admin.database.saveAuto');

        // Acciones de Restauración
        Route::post('/restaurar', [AdminController::class, 'restore'])->name('admin.database.restore');
        Route::post('/restaurar-subida', [AdminController::class, 'restoreUpload'])->name('admin.database.restore.upload');
    });
    
});

/*
|------------------------------------------------------
| 5. RUTAS DE MANTENIMIENTO Y TAREAS PROGRAMADAS
|------------------------------------------------------
*/
Route::get('/limpiar-magico', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return '¡Caché, configuración y rutas de Hostinger borradas con éxito!';
});

Route::get('/run-auto-backup', [BackupController::class, 'runAutoBackup']);

/*
|------------------------------------------------------
| RUTAS TEMPORALES PARA PROBAR VISTAS DE ERROR
|------------------------------------------------------
*/
Route::prefix('test-errors')->group(function () {
    Route::get('/403', function () { abort(403); }); // RASP / Prohibido
    Route::get('/404', function () { abort(404); }); // No encontrado
    Route::get('/500', function () { abort(500); }); // Error de servidor
    Route::get('/419', function () { abort(419); }); // Sesión expirada
    Route::get('/401', function () { abort(401); }); // No autorizado
});

// routes/web.php

Route::get('/admin/database/api/metrics', [AdminController::class, 'getMetricsApi'])->name('admin.database.api.metrics');


Route::post('admin/sistema/base-de-datos/optimizar', [DatabaseController::class, 'optimize'])->name('admin.database.optimize');
Route::post('admin/sistema/base-de-datos/reindexar', [DatabaseController::class, 'reindex'])->name('admin.database.reindex');
Route::post('admin/sistema/base-de-datos/limpiar', [DatabaseController::class, 'cleanup'])->name('admin.database.cleanup');
Route::get('admin/sistema/base-de-datos/reportes', [DatabaseController::class, 'reports'])->name('admin.database.reports');
Route::post('admin/sistema/base-de-datos/descargar-reporte', [DatabaseController::class, 'downloadReport'])->name('admin.database.report.download');
Route::post('admin/sistema/base-de-datos/restaurar-subida', [App\Http\Controllers\BackupController::class, 'restoreUpload'])->name('admin.database.restore.upload');
Route::get('/admin/api/category-sales', [App\Http\Controllers\Admin\DashboardController::class, 'apiCategoryRotation'])->name('admin.api.category_sales');
Route::get('/admin/export/ganancias', [DashboardExportController::class, 'exportGanancias'])->name('admin.export.ganancias');
Route::get('/admin/export/rotacion', [DashboardExportController::class, 'exportRotacion'])->name('admin.export.rotacion');
