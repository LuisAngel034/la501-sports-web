<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/html; charset=utf-8');

try {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo "<h1>🧹 Éxito</h1><p>La caché general, de configuración y de rutas de Laravel ha sido completamente limpiada con éxito.</p>";
} catch (Exception $e) {
    echo "<h1>❌ Error</h1><p>" . $e->getMessage() . "</p>";
}
