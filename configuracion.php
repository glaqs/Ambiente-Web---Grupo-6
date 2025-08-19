<?php
session_start();
include "config.php";

if (isset($_SESSION['user_id']) && isset($_POST['notificaciones'])) {
    $noti = $_POST['notificaciones'];

    $sql = "UPDATE usuarios SET notificaciones=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $noti, $_SESSION['user_id']);
    $stmt->execute();

    // Mensaje según el estado de las notificaciones
    if ($noti == '1' || $noti == 'activadas') {
        $_SESSION['mensaje'] = "✅ Notificaciones activadas";
    } else {
        $_SESSION['mensaje'] = "🔕 Notificaciones desactivadas";
    }
    
    $_SESSION['tipo_mensaje'] = "exito"; 
}

header("Location: index.php"); // Regresa al index
exit();