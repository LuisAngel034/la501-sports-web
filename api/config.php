<?php

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'u660523345_501Centro');
define('DB_PASS', '$25XDu=a3Ly');
define('DB_NAME', 'u660523345_la501');

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