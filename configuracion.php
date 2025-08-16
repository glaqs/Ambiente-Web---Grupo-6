<?php
session_start();
include "config.php";

if(isset($_SESSION['user_id']) && isset($_POST['notificaciones'])) {
    $noti = $_POST['notificaciones'];

    $sql = "UPDATE usuarios SET notificaciones=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $noti, $_SESSION['user_id']);
    $stmt->execute();

    $_SESSION['mensaje'] = "Configuración guardada correctamente";
}

header("Location: index.php"); // Regresa al index
exit();
?>
