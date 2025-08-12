<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$categoria = trim($_POST['categoria'] ?? '');
$monto = filter_var($_POST['monto'] ?? 0, FILTER_VALIDATE_FLOAT);
$descripcion = trim($_POST['descripcion'] ?? '');
$fecha = $_POST['fecha'] ?? '';

if (!$categoria || $monto === false || $monto <= 0 || !$fecha) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato de fecha inválido']);
    exit;
}

try {
    require 'conexion.php';

    $stmt = $pdo->prepare("INSERT INTO gastos (user_id, categoria, monto, descripcion, fecha) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $categoria, $monto, $descripcion, $fecha]);

    echo json_encode(['success' => true, 'message' => 'Gasto registrado correctamente']);
} catch (PDOException $e) {
    http_response_code(500);
    error_log("Error BD gasto: " . $e->getMessage());
    echo json_encode(['error' => 'Error al registrar gasto']);
}
