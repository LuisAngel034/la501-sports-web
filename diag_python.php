<?php
header('Content-Type: text/plain; charset=utf-8');

echo "=== disable_functions ===\n";
echo ini_get('disable_functions') ?: '(vacío, nada deshabilitado)';
echo "\n\n";

echo "=== PATH que ve PHP ===\n";
echo getenv('PATH') ?: '(no definido)';
echo "\n\n";

echo "=== Intentos con shell_exec (which / command -v) ===\n";
if (function_exists('shell_exec')) {
    foreach (['which python3', 'which python', 'command -v python3', 'whereis python3'] as $cmd) {
        $out = @shell_exec($cmd . ' 2>&1');
        echo "$ $cmd\n" . ($out !== null ? $out : '(sin salida / falló)') . "\n";
    }
} else {
    echo "shell_exec no está disponible.\n";
}
echo "\n";

echo "=== Probando rutas comunes de python3 en hosting compartido ===\n";
$candidatos = [
    'python3',
    '/usr/bin/python3',
    '/usr/local/bin/python3',
    '/opt/alt/python311/bin/python3',
    '/opt/alt/python312/bin/python3',
    '/opt/alt/python310/bin/python3',
    '/opt/alt/python39/bin/python3',
    '/opt/cpanel/ea-python311/root/usr/bin/python3',
    '/opt/plesk/python/3.11/bin/python3',
];
foreach ($candidatos as $bin) {
    $out = @shell_exec(escapeshellarg($bin) . ' --version 2>&1');
    $ok = $out && stripos($out, 'python') !== false;
    echo ($ok ? "[OK] " : "[  ] ") . "$bin -> " . trim((string) $out) . "\n";
}
echo "\n";

echo "=== Prueba real con proc_open (igual que hace Laravel) ===\n";
foreach (['python3', '/usr/bin/python3'] as $bin) {
    $desc = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $proc = @proc_open([$bin, '--version'], $desc, $pipes);
    if (is_resource($proc)) {
        $out = stream_get_contents($pipes[1]);
        $err = stream_get_contents($pipes[2]);
        fclose($pipes[0]); fclose($pipes[1]); fclose($pipes[2]);
        $code = proc_close($proc);
        echo "proc_open('$bin') -> exit=$code stdout=" . trim($out) . " stderr=" . trim($err) . "\n";
    } else {
        echo "proc_open('$bin') -> no se pudo iniciar el proceso\n";
    }
}

echo "\n=== PHP y sistema ===\n";
echo "PHP: " . PHP_VERSION . " | SAPI: " . php_sapi_name() . "\n";
echo "posix_spawn disponible: " . (function_exists('posix_getpid') ? 'extensión posix presente' : 'no') . "\n";
