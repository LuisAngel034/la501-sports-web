<?php

use Illuminate\Support\Facades\Route;

// 1. Públicos y Autenticación
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuController;

// 2. Empleados
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\DeliveryController;

// 3. Administrador
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\UserController;


/*
|--------------------
| 1. RUTAS PÚBLICAS
|--------------------
*/
Route::get('/', function () { return view('quienes-somos'); })->name('nosotros');
Route::get('/contacto', function () { return view('contacto'); })->name('contacto');
Route::get('/reservaciones', function () { return view('reservaciones'); })->name('reservaciones');
Route::get('/ubicacion', function () { return view('ubicacion'); })->name('ubicacion');

Route::get('/a-domicilio', [PageController::class, 'index'])->name('pedido');
Route::get('/novedades', [PageController::class, 'novedades'])->name('novedades');
Route::get('/promociones', [PageController::class, 'promociones'])->name('promociones');

// Menú de Visualización y su API de actualización en vivo
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/api/menu/products', function() {
    return response()->json(\App\Models\Product::where('available', 1)->get());
})->name('api.menu.products');

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

    // Recuperación - 1. Pedir el código
    Route::get('/recuperar', 'showRecuperar')->name('password.request');
    Route::post('/recuperar', 'enviarCodigo')->name('password.email');

    // Recuperación - 2. Escribir el código
    Route::get('/recuperar/verificar-codigo', 'showVerifyCode')->name('password.verify.code');
    Route::post('/recuperar/verificar-codigo', 'verifyCode')->name('password.verify.code.post');

    // Recuperación - 3. Cambiar la contraseña
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

    // Meseros
    Route::prefix('mesero')->group(function () {
        Route::get('/mesas', [WaiterController::class, 'index'])->name('mesero.mesas');
        Route::get('/mesas/{id}/pedido', [WaiterController::class, 'tomarPedido'])->name('mesero.pedido');
        Route::put('/mesas/{id}/cobrar', [WaiterController::class, 'cobrar'])->name('mesero.cobrar');
        Route::post('/mesas/{id}/pedido', [WaiterController::class, 'guardarPedido'])->name('mesero.guardar_pedido');
    });

    // Repartidores
    Route::prefix('entregas')->group(function () {
        Route::get('/', [DeliveryController::class, 'index'])->name('repartidor.index');
        Route::put('/{id}/completar', [DeliveryController::class, 'deliver'])->name('repartidor.deliver');
    });
});


/*
|------------------------------------------------------
| 4. RUTAS DEL ADMINISTRADOR (Protegidas y Seguras)
|------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard y API de Gráficas/Estadísticas
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/exportar-ventas', [DashboardController::class, 'exportSalesCSV'])->name('admin.sales.export.excel');
    Route::get('/api/stats', [DashboardController::class, 'apiStats'])->name('admin.api.stats');
    Route::get('/api/sales', [DashboardController::class, 'apiSales'])->name('admin.api.sales');
    
    // Rutas heredadas de tu controlador AdminController original
    Route::get('/ventas', [AdminController::class, 'ventas'])->name('admin.ventas');
    Route::get('/reservaciones', [AdminController::class, 'reservaciones'])->name('admin.reservations.index');
    Route::get('/api/sales-data', [AdminController::class, 'getSalesData']);
    Route::get('/api/orders/latest', function() {
        return \App\Models\Order::with('items')->latest()->take(10)->get();
    })->name('admin.api.orders');

    // Gestión del Menú
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('admin.menu');
    Route::get('/menu/exportar', [AdminMenuController::class, 'exportCSV'])->name('admin.menu.export');
    Route::post('/menu/importar', [AdminMenuController::class, 'importCSV'])->name('admin.menu.import');
    Route::post('/menu/store', [AdminMenuController::class, 'store'])->name('admin.menu.store');
    Route::put('/menu/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/menu/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');
    
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
    Route::get('/promociones', [PromotionController::class, 'index'])->name('admin.promotions.index');
    Route::post('/promociones', [PromotionController::class, 'store'])->name('admin.promotions.store');
    Route::put('/promociones/{id}', [PromotionController::class, 'update'])->name('admin.promotions.update');
    Route::delete('/promociones/{id}', [PromotionController::class, 'destroy'])->name('admin.promotions.destroy');

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

    // 👇 SECCIÓN DE INVENTARIO CORREGIDA 👇
    Route::get('/inventario/exportar', [InventoryController::class, 'exportCSV'])->name('admin.inventory.export');
    Route::post('/inventario/importar', [InventoryController::class, 'importCSV'])->name('admin.inventory.import');
    Route::resource('inventario', InventoryController::class)->except(['create', 'show', 'edit'])->names('admin.inventory');
    Route::put('/inventario/{id}/ajustar', [InventoryController::class, 'adjust'])->name('admin.inventory.adjust');

    // Gestión de Mensajes (CRM)
    Route::get('/mensajes', [AdminController::class, 'mensajes'])->name('admin.mensajes');
    Route::put('/mensajes/{id}/marcar-leido', [AdminController::class, 'marcarRespondido'])->name('admin.mensajes.leido');
});

Route::get('/limpiar-magico', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear'); 
    return '¡Caché, configuración y rutas de Hostinger borradas con éxito!';
});

Route::post('/contacto/enviar', [PageController::class, 'enviarContacto'])->name('contacto.enviar');