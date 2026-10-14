<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (class_exists(\Dotenv\Dotenv::class)) {
    \Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();
}

define('DB_HOST', trim($_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: '127.0.0.1'));
define('DB_USER', trim($_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: ''));
define('DB_PASS', $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '');
define('DB_NAME', trim($_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?: ''));

function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        http_response_code(500);
        die(json_encode(['error' => 'Error de conexión']));
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    die(json_encode(['error' => 'Método no permitido']));
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
