<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    die("Usuario no autenticado");
}

if (isset($_POST['mensaje'])) {
    $mensaje = $_POST['mensaje'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO notificaciones (user_id, mensaje) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $mensaje);
    if ($stmt->execute()) {
        echo "Notificación creada correctamente";
    } else {
        echo "Error al crear notificación";
    }
}
