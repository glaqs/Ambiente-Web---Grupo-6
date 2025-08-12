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
    echo json_encode(['error' => 'Acceso denegado. Por favor inicia sesión.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$notificaciones = (isset($_POST['notificaciones']) && $_POST['notificaciones'] === 'on') ? 'on' : 'off';

try {
    require 'conexion.php';

    $stmt = $pdo->prepare("
        INSERT INTO configuracion (user_id, notificaciones) 
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE 
            notificaciones = VALUES(notificaciones), 
            actualizado_en = CURRENT_TIMESTAMP
    ");

    $stmt->execute([$user_id, $notificaciones]);

    echo json_encode(['success' => true, 'message' => "Configuración guardada: Notificaciones $notificaciones"]);
} catch (PDOException $e) {
    http_response_code(500);
    error_log("Error BD configuración: " . $e->getMessage());
    echo json_encode(['error' => 'Error al guardar la configuración.']);
}
